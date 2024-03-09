<?php
/*
** Master Controller
*
*/

declare(strict_types=1);

namespace app\core;

class Controller
{

    //? method to load view pages
    public function view(string $view, array $data = []): void
    {
        extract($data);


        if (file_exists("../app/views/" . $view . ".php")) {
            require("../app/views/" . $view . ".php");
        } else {
            require("../app/views/404.php");
        }
    }

    //? method to load a contronller
    public function load_model($model)
    {

        if (file_exists("../app/models/" . ucwords($model) . ".php")) {
            require("../app/models/" . ucwords($model) . ".php");
            return $model = new $model();
        }
        return false;
    }


    //? method to redirect to a specific route
    public function redirect($link)
    {
        header('Location: ' . URLROOT . "/" . trim($link, "/"));
        die();
    }

    //? method to get a currecnt class name
    public function controller_name()
    {
        return get_class($this);
    }


    //? method to send json data to the front end
    protected function sendJsonResponse(string $status, string $message,  array|null $data = null): never
    {
        $response['status'] = $status;
        $response['message'] = $message;

        if ($data !== null) {
            $response['data'] = $data;
        }

        echo json_encode($response);
        exit;
    }
}
