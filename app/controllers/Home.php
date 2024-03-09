<?php
/*
** Home Controller
*
*/

use app\core\Controller;
use app\models\Auth;
use app\models\Cars;
use app\models\User;

class Home extends Controller
{
    private $jsonData;

    public function __construct()
    {
        $this->jsonData = file_get_contents("php://input");
        $this->jsonData = json_decode($this->jsonData);
    }

    public function index()
    {
        $vehicle = new Cars();
        $data['cars'] = $vehicle->findAll();

        $this->view('dashboard', $data);
    }
}
