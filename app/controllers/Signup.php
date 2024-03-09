<?php
/*
** Signup Controller
*
*/

use app\core\Controller;
use app\models\Auth;
use app\models\User;

class Signup extends Controller
{

    private $jsonData;

    public function __construct()
    {
        //? redirect to login when user is not logedin
        if (Auth::logged_in()) {
            $this->redirect('home');
        }

        //? get json datas from frontend
        $this->jsonData = file_get_contents("php://input");
        $this->jsonData = json_decode($this->jsonData);
    }

    //? method to submit and validate data
    public function submit_registration()
    {
        if ($this->jsonData) {

            $user = new User();
            $validated = $user->validate((array) $this->jsonData);

            if ($validated) {
                //? current date and time
                $dateTimeNow = new DateTime();

                $this->jsonData->created_at = $dateTimeNow->format('Y-m-d H:i:s');

                //? insert data into user table
                $user->insert((array) $this->jsonData);

                $_SESSION['registered'] = "Registered Successfully";

                //? Upadate user session
                Auth::authenticate($user->where('email', $this->jsonData->email)[0]);

                //? data sent to frontend
                $data['redirectLink'] = URLROOT;
                $data['error'] = null;

                //? send a response to the frontend
                $this->sendJsonResponse(
                    STATUS_SUCCESS,
                    'User registered successfully',
                    $data
                );
            } else {

                //? errors from the user model
                $data['error'] = $user->errors;

                //? send a response to the frontend
                $this->sendJsonResponse(
                    STATUS_ERROR,
                    'Validation error',
                    $data
                );
            }
        } else {

            $this->sendJsonResponse(
                STATUS_ERROR,
                'Unable to fetch json data'
            );
        }
    }


    //? method to display customer registration page
    public function customer()
    {
        $this->view('signup_customer');
    }

    //? method to display agency registration page
    public function agency()
    {
        $this->view('signup_agency');
    }
}
