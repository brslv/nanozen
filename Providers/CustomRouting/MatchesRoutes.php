<?php

namespace Nanozen\Providers\CustomRouting;

use Nanozen\Utilities\Csrf;

/**
 * Trait MatchesRoutes
 *
 * @author brslv
 * @package Nanozen\Providers\CustomRouting
 */
trait MatchesRoutes
{

    protected function match()
    {
        return $this->performRouteMatchingAlgorithm();
    }

    private function performRouteMatchingAlgorithm()
    {	
        $this->parseUrl();
        $routesArray = $this->routes;
        $isAreaRoute = false;
        
        if ($this->areaExists()) {
            $routesArray = $this->areas[$this->urlSegments[0]]['routes'];
            $isAreaRoute = true;
        }

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

        if ( ! in_array($requestMethod, $this->allowedRequestMethods)) {
            throw new \Exception("HTTP method {$requestMethod} not allowed.");
        }
	
        // Token check
        if ($requestMethod != 'get') {
            if(isset($_POST['_method'])) {
            	if ( ! isset($_POST['_token'])) {
            		$this->viewProviderContract->render('errors.401');
            	}
            	
                if (Csrf::validate($_POST['_token'])) {
                    $requestMethod = strtolower($_POST['_method']);
                }
            } 
        }

        foreach ($routesArray[$requestMethod] as $route => $target) {
            // var_dump($route);
            if ($isAreaRoute) $route = $this->urlSegments[0] . '/' . $route;

            $routeSegments = $route == '/'
                ? ['/']
                : preg_split('#/#', $route, null, PREG_SPLIT_NO_EMPTY);
            $urlSegmentsCount = count($this->urlSegments);
            $routeSegmentsCount = count($routeSegments);
            
            $routeMatches = true;

            // try with || $urlSegments > $routeSegments + 1
            if ($urlSegmentsCount > $routeSegmentsCount) {
                continue;
            }

            for ($i = 0; $i < $routeSegmentsCount; $i++) {
                $currentRouteSegment = $routeSegments[$i];
                $currentUrlSegment = isset($this->urlSegments[$i]) ? $this->urlSegments[$i] : null;

                if ($this->isRouteSegmentParameter($currentRouteSegment)) {
                    if ($currentUrlSegment == null &&
                        ! $this->isRouteSegmentOptional($currentRouteSegment))
                    {
                        $routeMatches = false;
                        break;
                    }

                    // match regexes
                    preg_match('#(?:{)(.*?)(:[a-z])*?(?:}|\?)#', $currentRouteSegment, $routeSegmentPartials);

                    $routeSegmentName = isset($routeSegmentPartials[1])
                        ? $routeSegmentPartials[1]
                        : null;
                    $routeSegmentType = isset($routeSegmentPartials[2])
                        ? $routeSegmentPartials[2]
                        : null;

                    if ( ! array_key_exists($routeSegmentType, $this->patterns)) {
                        throw new \Exception("Invalid segment type in route: {$route}");
                    }

                    $routeSegmentRegex = $this->patterns[$routeSegmentType];
                    preg_match($routeSegmentRegex, $currentUrlSegment, $urlSegmentMatchesRegex);

                    if (empty($urlSegmentMatchesRegex)) {
                        $routeMatches = false;
                        break;
                    } else {
                        if ($urlSegmentMatchesRegex[0] != $currentUrlSegment) {
                            $routeMatches = false;
                            break;
                        }
                    }

                    // everything's fine
                    // put the url value in the extracted values
                    $this->extractedVariables[$routeSegmentName] = $urlSegmentMatchesRegex[0];
                } else {
                    if ( 0 != strcasecmp($currentRouteSegment, $currentUrlSegment)) {
                        $routeMatches = false;
                        break;
                    }
                }

                // is this the last element
                // if everythings fine - we have a match.
                $optionalSegments = $this->getOptionalSegmentsForRoute($routeSegments);

                $isLastRouteSegment = $i == $routeSegmentsCount - 1 - $optionalSegments;

                if ($urlSegmentsCount == $routeSegmentsCount) {
                    $isLastRouteSegment = $i == $routeSegmentsCount - 1;
                }

                if ($isLastRouteSegment && $routeMatches) {
                    $this->matchedRoutes[] = $route;
                }
            }
        }

        // Automatic routing.
        if (empty($this->matchedRoutes)) {
            $this->autoRoutingProviderContract->invoke($this->routes, $this->areas);
        }

        // Check for area route and match it.
        if ( ! empty($this->matchedRoutes)) {
            // The target of the first matched route.
            if ($isAreaRoute) {
                $matched = $this->matchedRoutes[0] != $this->urlSegments[0] . '//'
                    ? ltrim(substr($this->matchedRoutes[0], strlen($this->urlSegments[0])), '/')
                    : '/';

                if (isset($this->areas[$this->urlSegments[0]]['folder'])) {
                    $areaFolderPrefix = $this->areas[$this->urlSegments[0]]['folder'];
                } else {
                    throw new \Exception('No such area. Did you missed to initiate the area before adding a route to it? Use $router->area() function.');
                }
                
                $target = $areaFolderPrefix . '|' . $this->areas[$this->urlSegments[0]]['routes'][$requestMethod][$matched];
            } else {
                $target = $this->routes[$requestMethod][$this->matchedRoutes[0]];
            }

            return $target;
        }

        return false;
    }

    private function areaExists()
    {
    	return array_key_exists($this->urlSegments[0], $this->areas);
    }
    
    public function isRouteSegmentParameter($routeSegment)
    {
        return substr($routeSegment, 0, 1) == '{' && substr($routeSegment, -1) == '}';
    }

    public function isRouteSegmentOptional($routeSegment)
    {
        return substr($routeSegment, 0, 1) == '{' && substr($routeSegment, -2) == '?}';
    }

    private function getOptionalSegmentsForRoute($routeSegments)
    {
        $countOfOptionalRouteSegments = 0;

        foreach ($routeSegments as $segment) {
            if ($this->isRouteSegmentOptional($segment)) {
                $countOfOptionalRouteSegments++;
            }
        }

        return $countOfOptionalRouteSegments;
    }

    // public function actionReservedByCustomRoute($controller, $action)
    // {
    //     foreach ($this->routes as $routeMethod => $route) {
    //         foreach ($route as $currentRoute) {
    //             list($currentRouteController, $currentRouteAction) = 
    //                 preg_split('/@/', $currentRoute, null, PREG_SPLIT_NO_EMPTY);

    //             if ($currentRouteController == $controller && $currentRouteAction == $action) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }

}