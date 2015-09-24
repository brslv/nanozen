<?php

namespace Nanozen\Providers\Routing;

/**
* Class RoutingProvider
*
* @author brslv 
* @package Nanozen\Providers\Routing
*/
class RoutingProvider
{

    use \Nanozen\Providers\Dispatching\AllowedRequestMethods;

	public $dependsOn = [
        'autoRoutingProviderContract',
        'dispatchingProviderContract', 
        'configProviderContract',
    ];

    protected $routes = [
        'get' => [],
        'post' => [],
        'patch' => [],
        'put' => [],
        'delete' => [],
    ];

    protected $areas = [
        // 'forum' => [
        //      'folder' => 'ForumArea'
        //      'routes' => [
        //          'get' => [],
        //          'post' => [],
        //          'put' => [],
        //          ...
        //          ...
        //      ]
        // ]
    ];

    protected $patterns = [
        ':i' => '#[0-9]+#',         // represents integers
        ':s' => '#[a-zA-Z]+#',      // represents strings
        ':a' => '#.+#',             // represents everything
    ];

    protected $matchedRoutes = [];

    protected $extractedVariables = [];

    protected $urlSegments;

    public function parseUrl()
    {
        $url =
            ! isset($_GET['url']) || trim($_GET['url']) == ""
                ? $_GET['url'] = '/'
                : $_GET['url'];

        $this->urlSegments =
            $url == '/'
                ? ['/']
                : preg_split('#/#', $_GET['url'], null, PREG_SPLIT_NO_EMPTY);

        return $this->urlSegments;
    }

}