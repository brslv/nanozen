<?php

namespace Nanozen\Providers\Dispatching;

use Nanozen\App\Base;
use Nanozen\App\Injector;
use Nanozen\Utilities\Csrf;
use Nanozen\Providers\Session\SessionProvider as Session;
use Nanozen\Contracts\Providers\Dispatching\DispatchingProviderContract;

/**
 * Class DispatchProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Dispatching
 */
class DispatchingProvider implements DispatchingProviderContract
{

    use InjectsBindingModels;
    use AllowedRequestMethods;

    public $dependsOn = [
        'configProviderContract', 
        'viewProviderContract',
    ];

    private $isAreaRoute = false;

    private $controller;

    private $action;

    private $params = [];

    public function dispatch($target, $variables)
    {
        $this->validateToken();

        if ( ! $target) {
            $this->throw404();
        }

        if (is_callable($target))
        {
            call_user_func($target);
            exit();
        }

        // Here call the target if it's comming from the automatic route matching mechanism.
        if (is_array($target) && 
            ! empty($target) && 
            $target['type'] == 'automatic_match'
        ) {
            $this->controller = Injector::call($target['controller']);
            $this->action = $target['action'];
            $this->params = $target['params'];

            $this->injectBindingModelIfAny();

            call_user_func_array([$this->controller, $this->action], $this->params);
            exit;
        }

        if (strpos($target, '|')) {
            $this->isAreaRoute = true;

            list($areaFolderPrefix, $targetControllerAndAction) = explode('|', $target);
            $target = $targetControllerAndAction;
        }

        list($this->controller, $this->action) = $this->extractControllerAndActionFromTarget($target);

        $this->controller = $this->configProviderContract->get('namespaces.controllers') . $this->controller;

        if ($this->isAreaRoute) {
            $areasNamespace = $this->configProviderContract->get('namespaces.areas');
            $this->controller = explode('\\', $this->controller);
            $this->controller = $areasNamespace . $areaFolderPrefix . '\\Controllers\\' . end($this->controller);
        }

        if ($this->controllerExists($this->controller)) {
            $variablesCount = count($variables);
            $actionRequiredParametersCount =
                (new \ReflectionMethod($this->controller, $this->action))
                    ->getNumberOfRequiredParameters();

            if ($actionRequiredParametersCount > $variablesCount) {
                $message = "Action {$action} requires {$actionRequiredParametersCount} parameters.
                {$variablesCount} given. Change the route's parameters or the action's ones.";

                throw new \Exception($message);
            }
            if ($this->actionExists($this->controller, $this->action)) {
                $this->controller = Injector::call($this->controller);

                $this->injectBindingModelIfAny();

                call_user_func_array([$this->controller, $this->action], $variables);

                exit;
            }
        }
    }

    private function validateToken()
    {
    	
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
            return true;
        } else {
            if(isset($_POST['_method'])) {
            	if ( ! isset($_POST['_token'])) {
            		$this->viewProviderContract->render('errors.401');
            	}
            	
                if (Csrf::validate($_POST['_token'])) {
                    return true;
                }

                http_response_code(401);
                $this->viewProviderContract->render('errors.401');
            } 
        }

        
        $this->throw404();
    }

    private function throw404()
    {
        http_response_code(404);
        $this->viewProviderContract->render('errors.404');
        // exit;
    }

    private function extractControllerAndActionFromTarget($target)
    {
        return preg_split('/@/', $target, null, PREG_SPLIT_NO_EMPTY);
    }

    private function controllerExists($controller)
    {
        return class_exists($controller);
    }

    private function actionExists($controller, $action)
    {
        return method_exists($controller, $action);
    }

}