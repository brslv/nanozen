<?php

namespace Nanozen\Providers\Dispatching;

use Nanozen\App\Base;
use Nanozen\App\Injector;
use Nanozen\Contracts\Providers\Dispatching\DispatchingProviderContract;

/**
 * Class DispatchProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Dispatching
 */
class DispatchingProvider implements DispatchingProviderContract
{

    public $dependsOn = ['configProviderContract', 'viewProviderContract'];

    private $isAreaRoute = false;

    public function dispatch($target, $variables)
    {

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
            $controller = $target['controller'];
            $action = $target['action'];
            $params = $target['params'];

            call_user_func_array([new $controller, $action], $params);

            exit;
        }

        if (strpos($target, '|')) {
            $this->isAreaRoute = true;

            list($areaFolderPrefix, $targetControllerAndAction) = explode('|', $target);
            $target = $targetControllerAndAction;
        }

        list($controller, $action) = $this->extractControllerAndActionFromTarget($target);
        
        $_controller = $this->configProviderContract->get('namespaces.controllers') . $controller;

        if ($this->isAreaRoute) {
            $areasNamespace = $this->configProviderContract->get('namespaces.areas');
            $_controller = $areasNamespace . $areaFolderPrefix . '\\Controllers\\' . $controller;
        }

        if ($this->controllerExists($_controller)) {
            $variablesCount = count($variables);
            $actionRequiredParametersCount =
                (new \ReflectionMethod($_controller, $action))
                    ->getNumberOfRequiredParameters();

            if ($actionRequiredParametersCount > $variablesCount) {
                $message = "Action {$action} requires {$actionRequiredParametersCount} parameters.
                {$variablesCount} given. Change the route's parameters or the action's ones.";

                throw new \Exception($message);
            }
            if ($this->actionExists($_controller, $action)) {
                $_controller = Injector::call($_controller);
                call_user_func_array([$_controller, $action], $variables);

                exit;
            }
        }
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