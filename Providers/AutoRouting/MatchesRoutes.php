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

    private $isAreaRoute = false;

    private $controllerUrlIndex = 0;

    private $actionUrlIndex = 1;

    protected function matchAndPrefer($customRoutes, $areas)
    {
        $this->routes = $customRoutes;

        $this->areas = $areas;

        return $this->performMatchingAlgorithm(); 
    }

	protected function performMatchingAlgorithm()
	{
        $this->parseUrl();

		$controllerClassName = null;
        $action = null;

        if (isset($this->urlSegments[$this->controllerUrlIndex])) {
            // If the url is '/' - get the default controller.
            if ($this->urlSegments[$this->controllerUrlIndex] == '/') {
                $defaultControllerFullName = $this->configProviderContract->get('defaults.controller');
                $defaultControllerFullClassNameSplitted = preg_split("/\\\/", $defaultControllerFullName, null, PREG_SPLIT_NO_EMPTY);
                $controllerClassName = end($defaultControllerFullClassNameSplitted);
                $controllerFullName = $defaultControllerFullName;
            }
            // Else - get the specified controller from the url.
            else {
                // check if the user is calling a areas route
                if ($this->userCallsForAreaRoute())
                {
                    $this->switchToAutoRouteMatchingForAreas();
                }

                $defaultControllerNamespace = $this->getDefaultControllerNamespace();
                $controllerClassName = $this->configProviderContract->get('defaults.controller_area');

                if (isset($this->urlSegments[$this->controllerUrlIndex])) {
                    $controllerClassName = ucfirst($this->urlSegments[$this->controllerUrlIndex]) . 'Controller';
                }
                $controllerFullName = $defaultControllerNamespace . $controllerClassName; 
            }

            unset($this->urlSegments[$this->controllerUrlIndex]);
        }

        if (isset($this->urlSegments[$this->actionUrlIndex])) {
            $action = $this->urlSegments[$this->actionUrlIndex];
            unset($this->urlSegments[$this->actionUrlIndex]);
        }
        
        if (is_null($action)) {
            $action = $this->configProviderContract->get('defaults.action');
        }

        // Check if the action is reserved by a custom route.
        // If so - false.
        if ( ! $this->isAreaRoute) {
            if ($this->actionReservedByCustomRoute($controllerClassName, $action)) {
                return false;
            }
        }

        if ($this->isAreaRoute) {
            unset($this->urlSegments[0]);
        }

        $params = ! empty($this->urlSegments) ? array_values($this->urlSegments) : [];

        if (($target = $this->targetCanBeCalled($controllerFullName, $action, $params)) != false) {
            return $target;
        }

        return false;
	}

    private function userCallsForAreaRoute()
    {
        return array_key_exists($this->urlSegments[$this->controllerUrlIndex], $this->areas);
    }

    private function switchToAutoRouteMatchingForAreas()
    {
        $this->isAreaRoute = true;
        $this->controllerUrlIndex = 1;
        $this->actionUrlIndex = 2;
    }

    private function getDefaultControllerNamespace()
    {
        if (isset($this->areas[$this->urlSegments[0]]['folder'])) {
            $areaFolderPrefix = $this->areas[$this->urlSegments[0]]['folder'];
        }
     
        return $this->isAreaRoute == false
                    ? $this->configProviderContract->get('namespaces.controllers')
                    : $this->configProviderContract->get('namespaces.areas') . $areaFolderPrefix . '\\Controllers\\';
    }

    private function actionReservedByCustomRoute($controller, $action)
    {
        foreach ($this->routes as $routeMethod => $route) {
            foreach ($route as $currentRoute) {
                if (is_callable($currentRoute)) {
                    continue;
                }

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
                    $this->viewProviderContract->render('errors.404');
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