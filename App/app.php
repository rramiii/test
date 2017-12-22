<?php
namespace App;
use App\trip_reoute\controllers\organise_trip\controller;

/**
 * Created by PhpStorm.
 * User: rami
 * Date: 22/12/17
 * Time: 10:18
 */
class App {

    var $version = "0.0.1";
    var $name = "my App";
    var $db_connection = [];
    var $defined_modules = [];
    var $modules_config = [];
    var $routes = [];
    var $router;

    function __construct()
    {
        define("CONF_FILE", ROOT . 'etc/config.json');
        define("LOG_DIR", ROOT . 'var/log/');
        define("APP_DIR", ROOT . 'App/');
        $this->requireMainClases();
        $this->loadConfig();
        $this->loadModulesConfig();

        try{
            $this->router = new router($_SERVER['REDIRECT_URL'], APP_DIR);
        }catch (\Exception $ex) {
            $tt = "tt";
        }
    }
    function requireMainClases(){
        // TODO make following not fixed values as it's now!
        require_once("router.php");
        require_once(APP_DIR . "core/controllers/controller.php");
        require_once(APP_DIR . "core/model/module.php");
    }

    function loadConfig() {
        $config = file_get_contents(CONF_FILE);
        try{
            $config = json_decode($config, true);
            $this->version = $config["version"];
            $this->name = $config["name"];
            $this->db_connection = $config["DB"];
            $this->defined_modules = $config["modules"];

        } catch (\Exception $ex) {
            // TODO log the occurred error in logs
        }
    }

    function loadModulesConfig() {
        if($this->defined_modules && is_array($this->defined_modules)) {
            $module_dir = "";
            try {
                foreach ($this->defined_modules as $module) {
                    $module_dir = APP_DIR . $module;
                    if(file_exists($module_dir) && is_dir($module_dir)) {
                        $config = file_get_contents($module_dir. '/etc/config.json');
                        $config = json_decode($config, true);
                        $this->modules_config[$module] = $config;  // save module conf

                        // save route to module
                        $route_keys = array_keys($config["routes"]?: []);
                        $module_routes = array_fill_keys($route_keys, $module);
                        $this->routes = array_merge($this->routes, $module_routes); // TODO handle same route used twice case!
                    }
                }
            }catch (\Exception $ex) {
                // TODO log occurred Error first
                throw new \Exception("Error in loading modules");
            }

        }else {
            throw new \Exception("Error in loading modules");
        }
    }

    public function dispatch() {
        $requestDetails = $this->router->route($this->modules_config, $this->routes);

        if(!empty($requestDetails)) {

            $requestDetails['method'] = $_SERVER['REQUEST_METHOD'];
            $requestDetails['URI'] = $_SERVER['REDIRECT_URL'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $_POST = array_merge($_POST, $requestDetails['params']);
                $requestDetails = array_merge($requestDetails, $_POST);

            } else {

                $_GET = array_merge($_GET, $requestDetails['params']);
                $requestDetails = array_merge($requestDetails, $_GET);
            }

            // TODO log the request
            require_once($requestDetails['dir']);

            $moduleConfig = $this->modules_config[$requestDetails['taget_module']];
            $moduleRequires = ($moduleConfig["requires"] && $moduleConfig["requires"][$requestDetails['current_route']])?
                $moduleConfig["requires"][$requestDetails['current_route']]: [];
            $moduleDir = $requestDetails['module_dir'];
            if(!empty($moduleRequires)) {
                foreach ($moduleRequires as $type => $set) {
                    foreach ($set as $model) {
                        require_once($moduleDir .'/'.$type.'/'. $model . '.php');
                    }
                }
            }
            $relativeTemplate = $moduleConfig['view']['templates'][$requestDetails["current_route"]];
            $template = $relativeTemplate? $requestDetails['module_dir'] . '/templates/'.$relativeTemplate.'.phtml' : "";
            $controller = new controller($template);
            $controller->execute();

        } else {
            header('X-PHP-Response-Code: 404', true, 404);
            require_once(dirname(__FILE__) . '/404.phtml');
        }
    }
}