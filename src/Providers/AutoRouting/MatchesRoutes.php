<?php

namespace Nanozen\Providers\AutoRouting;

/**
 * Trait MatchesRoutes
 *
 * @author brslv
 * @package  Nanozen\Providers\AutoRouting
 */
trait MatchesRoutes
{

    protected function matchAndPrefer($customRoutes)
    {
        $this->routes = $customRoutes;

        return $this->performMatchingAlgorithm(); 
    }

	protected function performMatchingAlgorithm()
	{
        $this->parseUrl();

		$controllerClassName = null;
        $action = null;

        if (isset($this->urlSegments[0])) {
            // If the url is '/' - get the default controller.
            if ($this->urlSegments[0] == '/') {
                $defaultControllerFullName = $this->configProviderContract->get('defaults.controller');
                $defaultControllerFullClassNameSplitted = preg_split("/\\\/", $defaultControllerFullName, null, PREG_SPLIT_NO_EMPTY);
                $controllerClassName = end($defaultControllerFullClassNameSplitted);
                $controllerFullName = $defaultControllerFullName;
            }
            // Else - get the specified controller from the url.
            else {
                $controllerClassName = ucfirst($this->urlSegments[0]) . 'Controller';
                $controllerFullName = $this->configProviderContract->get('namespaces.controllers') . $controllerClassName;    
            }

            unset($this->urlSegments[0]);
        }

        if (isset($this->urlSegments[1])) {
            $action = $this->urlSegments[1];
            unset($this->urlSegments[1]);
        }
        
        if (is_null($action)) {
            $action = $this->configProviderContract->get('defaults.action');
        }

        // Check if the action is reserved by a custom route.
        // If so - false.
        if ($this->actionReservedByCustomRoute($controllerClassName, $action)) {
            return false;
        }

        $params = ! empty($this->urlSegments) ? array_values($this->urlSegments) : [];

        if (($target = $this->targetCanBeCalled($controllerFullName, $action, $params)) != false) {
            return $target;
        }

        return false;
	}

    private function actionReservedByCustomRoute($controller, $action)
    {
        foreach ($this->routes as $routeMethod => $route) {
            foreach ($route as $currentRoute) {
                list($currentRouteController, $currentRouteAction) = 
                    preg_split('/@/', $currentRoute, null, PREG_SPLIT_NO_EMPTY);

                if ($currentRouteController == $controller && $currentRouteAction == $action) {
                    return true;
                }
            }
        }

        return false;
    }

    private function targetCanBeCalled($controller, $action, $params) 
    {
        if (class_exists($controller)) {
            $controllerObject = new $controller;    

            if (method_exists($controllerObject, $action)) {

                if ( ! $this->requiredParamsAreAvailable($controllerObject, $action, $params)) {
                    throw new \Exception('THROW 404'); // TODO throw 404 here!
                }

                $target = [
                    'type' => 'automatic_match',
                    'controller' => $controller,
                    'action' => $action,
                    'params' => $params,
                ];
                
                return $target;
            }
        }

        return false;
    }

    private function requiredParamsAreAvailable($controller, $action, $params)
    {
        $reflector = new \ReflectionMethod($controller, $action);
        $requiredParamsCount = $reflector->getNumberOfRequiredParameters();

        return $requiredParamsCount <= count($params);
    }

}