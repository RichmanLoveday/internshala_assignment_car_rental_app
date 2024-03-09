<?php
/*
** Routing Loader or class Loader
*
*/

declare(strict_types=1);

namespace app\core;

class App
{

    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Handle controller
        if (isset($url) && $url != []) {
            if (file_exists("../app/controllers/" . ucwords($url[0]) . ".php")) {
                $this->controller = ucwords($url[0]);
                unset($url[0]);
            } else {
                $controller = new Controller();
                $controller->view('404', ['pageTitle' => null]);
                exit;
            }
        }


        require "../app/controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller();

        // Handle Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = strtolower($url[1]);
                unset($url[1]);
            } else {
                $controller = new Controller();
                $controller->view('404', ['pageTitle' => null]);
                exit;
            }
        }

        $url = $url ? array_values($url) : [];
        $this->params = $url;

        // echo '<pre>';
        // print_r($url);
        // echo '<pre/>';

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function getUrl()
    {
        $url = isset($_GET['url']) ? clean_url($_GET['url']) : [];
        return $url;
    }
}