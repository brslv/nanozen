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

    protected function matchAndPrefer($customRoutes, $areas)
    {
        $this->routes = $customRoutes;

        $this->areas = $areas;

        return $this->performMatchingAlgorithm(); 
    }

	protected function performMatchingAlgorithm()
	{
        $this->parseUrl();

        $isAreaRoute = false;
        $controllerUrlIndex = 0;
        $actionUrlIndex = 1;

		$controllerClassName = null;
        $action = null;

        if (isset($this->urlSegments[$controllerUrlIndex])) {
            // If the url is '/' - get the default controller.
            if ($this->urlSegments[$controllerUrlIndex] == '/') {
                $defaultControllerFullName = $this->configProviderContract->get('defaults.controller');
                $defaultControllerFullClassNameSplitted = preg_split("/\\\/", $defaultControllerFullName, null, PREG_SPLIT_NO_EMPTY);
                $controllerClassName = end($defaultControllerFullClassNameSplitted);
                $controllerFullName = $defaultControllerFullName;
            }
            // Else - get the specified controller from the url.
            else {
                // check if the user is calling a areas route
                if (array_key_exists($this->urlSegments[$controllerUrlIndex], $this->areas))
                {
                    $isAreaRoute = true;
                    $controllerUrlIndex = 1;
                    $actionUrlIndex = 2;
                }

                if (isset($this->areas[$this->urlSegments[0]]['folder'])) {
                    $areaFolderPrefix = $this->areas[$this->urlSegments[0]]['folder'];
                }

                $defaultControllerNamespace = $isAreaRoute == false
                    ? $this->configProviderContract->get('namespaces.controllers')
                    : $this->configProviderContract->get('namespaces.areas') . $areaFolderPrefix . '\\Controllers\\';

                $controllerClassName = $this->configProviderContract->get('defaults.controller_area');

                if (isset($this->urlSegments[$controllerUrlIndex])) {
                    $controllerClassName = ucfirst($this->urlSegments[$controllerUrlIndex]) . 'Controller';
                }
                $controllerFullName = $defaultControllerNamespace . $controllerClassName; 
            }

            unset($this->urlSegments[$controllerUrlIndex]);
        }

        if (isset($this->urlSegments[$actionUrlIndex])) {
            $action = $this->urlSegments[$actionUrlIndex];
            unset($this->urlSegments[$actionUrlIndex]);
        }
        
        if (is_null($action)) {
            $action = $this->configProviderContract->get('defaults.action');
        }

        // Check if the action is reserved by a custom route.
        // If so - false.
        if ( ! $isAreaRoute) {
            if ($this->actionReservedByCustomRoute($controllerClassName, $action)) {
                return false;
            }
        }

        if ($isAreaRoute) {
            unset($this->urlSegments[0]);
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
                    throw new \Exception('THROW 404 - the route is not found'); // TODO throw 404 here!
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