<?php

namespace Nanozen\Providers\CustomRouting;

/**
 * Class MatchesRoutes
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

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

        if ( ! in_array($requestMethod, $this->allowedRequestMethods)) {
            throw new \Exception("HTTP method {$requestMethod} not allowed.");
        }

        foreach ($this->routes[$requestMethod] as $route => $target) {
            $routeSegments = $route == '/'
                ? ['/']
                : preg_split('#/#', $route, null, PREG_SPLIT_NO_EMPTY);
            $urlSegmentsCount = count($this->urlSegments);
            $routeSegmentsCount = count($routeSegments);

            $routeMatches = true;

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
            $this->autoRoutingProviderContract->invoke($this->routes);
        }

        if ( ! empty($this->matchedRoutes)) {
            // The target of the first matched route.

            $target = $this->routes[$requestMethod][$this->matchedRoutes[0]];
            return $target;
        }

        return false;
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