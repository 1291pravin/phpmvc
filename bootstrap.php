<?php

require_once(ROOT . "db/db.php");
require_once(ROOT . "base/Model.php");
require_once(ROOT . "base/Controller.php");

class Bootstrap {

    public $controller;
    public $action;
    public static $params;

    public function run() {
        self::$params = array_merge(require_once ROOT . '/config/params.php', require_once ROOT . '/config/params_local.php');
        $this->parseUrl($this->getUrl());
    }

    public function getUrl() {
        return $_SERVER["REQUEST_URI"];
    }

    public function parseUrl($url) {
        $url = trim($url);
        $explode_url = explode('/', $url);
        $explode_url = array_slice($explode_url, 1);
        $this->controller = $explode_url[0];
        $this->action = isset($explode_url[1]) ? $explode_url[1] : "";
        if (empty($this->controller)) {
            $this->controller = 'User';
        }
        if (empty($this->action)) {
            $this->action = 'index';
        }
        $controller = $this->loadController();
        if (method_exists($controller, $this->action) && is_callable(array($controller, $this->action))) {
            $params = array_slice($explode_url, 2);
            call_user_func_array([$controller, $this->action], $params);
        } else {
            $this->show404();
        }
    }

    public function loadController() {
        $name = $this->controller . "Controller";
        $file = ROOT . 'controllers/' . ucfirst($name) . '.php';
        if (file_exists($file)) {
            require_once($file);
            $controller = new $name();
            return $controller;
        }
        $this->show404();
    }

    public function show404() {
        $controller = new Controller();
        call_user_func_array([$controller, 'pageNotFound'], []);
        exit;
    }

}

?>