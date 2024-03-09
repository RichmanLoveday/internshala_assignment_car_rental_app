<?php
/*
** Home Controller
*
*/

use app\core\Controller;
use app\models\Auth;
use app\models\Bookings;

class Booking extends Controller
{
    private $jsonData;
    private $class;

    public function __construct()
    {
        //? redirect to login when user is not logedin
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $this->jsonData = file_get_contents("php://input");
        $this->jsonData = json_decode($this->jsonData);
        $this->class = get_class();
    }

    public function index()
    {
        $booking = new Bookings();
        $data['bookings'] = $booking->get_booked_vehicles(Auth::user()->user_id);

        $this->view('booked_vehicle', $data);
    }


    //? book a vehicle
    public function book_vehicle()
    {
        $booking = new Bookings();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $carID = $_POST['car_id'];

            if (Auth::user()->user_type == AGENCY) {
                $_SESSION['access_error'] = "As an agent, you have no access to book a car";
                return $this->redirect("vehicle/find/$carID");
            }

            //? validate data
            $validatedData = $booking->validate($_POST);

            if ($validatedData) {
                //? insert bookings table
                if ($booking->insert($_POST)) {
                    $_SESSION['booked'] = "Vehicle Booked Successfully";

                    //? redirect to vehicle page
                    return $this->redirect("vehicle/find/$carID");
                }
            } else {
                $_SESSION['booking_error'] = "Unable to book your desired vehicle check your input";

                //? redirect to vehicle page
                return $this->redirect("vehicle/find/$carID");
            }
        }
    }
}
