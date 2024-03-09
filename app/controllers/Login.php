<?php
/*
** Login Controller
*
*/

declare(strict_types=1);

use app\core\Controller;
use app\models\Auth;
use app\models\User;

class Login extends Controller
{
    public $jsonData;
    public function __construct()
    {
        //? redirect to login when user is not logedin
        if (Auth::logged_in()) {
            $this->redirect('home');
        }

        $this->jsonData = file_get_contents("php://input");
        $this->jsonData = json_decode($this->jsonData);
    }

    public function index()
    {
        if ($this->jsonData) {

            $email = $this->jsonData->email;
            $password = $this->jsonData->password;

            $user = new User();
            $row  = $user->where('email', $email);

            if (!empty($row) && password_verify($password, $row[0]->password)) {

                //? Authenticate user data
                Auth::authenticate($user->where('email', $email)[0]);

                //? hold sesssion on loggedIn
                $_SESSION['loggedIn'] = "Logged In successfully";

                //? data to send to front end
                $data['redirectLink'] = URLROOT;

                //? send response to front end
                $this->sendJsonResponse(STATUS_SUCCESS, 'Logged Successfully', $data);
            } else {

                //? data to send to front end
                $data['status'] = 'error';
                $data['message'] = "Email/Password Incorrect";

                //? send response to front end 
                $this->sendJsonResponse(STATUS_ERROR, 'Email/Password Incorrect', $data);
            }
        }
        return $this->view('login');
    }
}
