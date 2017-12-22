<?php
namespace App;
/**
 * Created by PhpStorm.
 * User: rami
 * Date: 22/12/17
 * Time: 10:29
 */
class router {

    private $_uri;
    private $_appBath;

    function __construct($uri, $appBath)
    {
        $this->setUri($uri);
        $this->setAppBath(rtrim($appBath, '/') . '/');
    }
    protected function setUri($uri)
    {
        $uri = trim($uri, '/');

        if (substr($uri, -4) === '.php')
        {
            $uri = substr($uri, 0, (strlen($uri) -4));
        } elseif(substr($uri, -5) === '.html') {

            $uri = substr($uri, 0, (strlen($uri) -5));
        }

        $this->_uri = trim($uri, '/');
    }
    public function getCurrentUri()
    {
        return $this->_uri;
    }

    protected function setAppBath($appBath)
    {
        $this->_appBath = $appBath;
    }

    public function getAppBath()
    {
        return $this->_appBath;
    }

    public function route($modules, $routes)
    {
        $uriParts = $this->getCurrentUri()? explode('/', $this->getCurrentUri()) : array();
        $appBath = $this->getAppBath();
        $details = null;

        if(!empty($uriParts)) {
            if(array_key_exists($uriParts[0], $routes)) {
                $targetModule = $routes[$uriParts[0]];

                $moduleDir = APP_DIR . $targetModule;
                $scriptDir = APP_DIR . $targetModule . '/controllers/'. $modules[$targetModule]['routes'][$uriParts[0]] .'/controller.php';
                $slicedUri = array_slice($uriParts, 1, count($uriParts));
                $params = $this->getParams($slicedUri);
                $details =     [
                    'taget_module' => $targetModule,
                    'module_dir' => $moduleDir,
                    'dir' => $scriptDir,
                    'params' => $params,
                    'current_route' => $uriParts[0],
                    ];

            }
        }

        return $details;
    }

    protected function getParams($uriParts)
    {
        $params = array();
        $uriLength = count($uriParts);
        if($uriLength  % 2 != 0) {

            $uriParts[$uriLength] = '';
        }

        for($i = 0; $i < $uriLength; $i += 2) {

            $params[$uriParts[$i]] = $uriParts[$i + 1];
        }

        return $params;
    }
}