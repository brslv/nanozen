<?php

namespace Nanozen\Providers\CustomRouting;

use Nanozen\App\Base;
use Nanozen\Contracts\Providers\CustomRouting\DispatchingProviderContract;

/**
 * Class DispatchProvider
 *
 * @author brslv
 * @package Nanozen\Providers\CustomRouting
 */
class DispatchingProvider implements DispatchingProviderContract
{

    public function dispatch($target, $variables, Base $base)
    {
        if ( ! $target) {
            $this->throw404();
        }

        if (is_callable($target))
        {
            call_user_func($target, $base);
            exit();
        }

        list($controller, $action) = $this->extractControllerAndActionFromTarget($target);

        if ($this->controllerExists($controller)) {
            $_controller = 'Nanozen\\Controllers\\' . $controller;
            $variablesCount = count($variables);
            $actionRequiredParametersCount =
                (new \ReflectionMethod('Nanozen\\Controllers\\' . $controller, $action))
                    ->getNumberOfRequiredParameters();

            if ($actionRequiredParametersCount > $variablesCount) {
                $message = "Action {$action} requires {$actionRequiredParametersCount} parameters.
                {$variablesCount} given. Change the route's parameters or the action's ones.";

                throw new \Exception($message);
            }

            if ($this->actionExists($_controller, $action)) {
                call_user_func_array([new $_controller($base), $action], $variables);
            }
        }
    }

    private function throw404()
    {
        http_response_code(404);
        echo "<h1>404</h1>";
        exit();
    }

    /**
     * @param $target
     * @return array
     */
    private function extractControllerAndActionFromTarget($target)
    {
        return preg_split('/@/', $target, null, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param $controller
     * @return bool
     */
    private function controllerExists($controller)
    {
        return class_exists('Nanozen\\Controllers\\' . $controller);
    }

    /**
     * @param $_controller
     * @param $action
     * @return bool
     */
    private function actionExists($_controller, $action)
    {
        return method_exists($_controller, $action);
    }

}