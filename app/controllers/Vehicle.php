<?php
/*
** Home Controller
*
*/

use app\core\Controller;
use app\models\Auth;
use app\models\Cars;

class Vehicle extends Controller
{
    private $jsonData;

    public function __construct()
    {
        //? get json datas from frontend
        $this->jsonData = file_get_contents("php://input");
        $this->jsonData = json_decode($this->jsonData);
    }

    public function add_new()
    {
        //? redirect to login when user is not logedin
        if (!Auth::logged_in()) {
            $this->redirect('home');
        }

        //? get car details based on agency ID
        $cars = new Cars();
        $agencyID = Auth::user()->user_id;
        $agencyCars = $cars->where('agency_id', $agencyID);

        //? send data to view
        $data['agencyCars'] = $agencyCars;
        return $this->view('add_new_car', $data);
    }

    public function find(string $vehicleID)
    {
        $vehicle = new Cars();
        $car = $vehicle->where('car_id', $vehicleID);

        if (!$car) return $this->view('404');

        $data['car'] = $car[0];
        $data['vehicleID'] = $vehicleID;

        //? send data to view
        $this->view('single_vehicle', $data);
    }


    public function add_new_car()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $this->jsonData) {
            $cars = new Cars();
            $formDatas = $_POST;

            //? Validate car datas
            $validated = $cars->validate($formDatas);

            if ($validated) {

                //? upload image 
                $imageUpload = upload_image($_FILES, 500, 500, 'car_images');

                if (!$imageUpload) return $this->sendJsonResponse(STATUS_ERROR, 'Unable to update image');

                //? link to uploaded image
                $formDatas['image_url'] = $imageUpload;

                //? attach agencyID
                $formDatas['agency_id'] = Auth::user()->user_id;


                //? insert new car details
                if ($cars->insert($formDatas)) {
                    $_SESSION['car_update'] = "Car Details Inserted Successfully";

                    //? return a success json
                    return $this->sendJsonResponse(
                        STATUS_SUCCESS,
                        'Car Details Inserted Successfully',
                        ['redirectLink' =>  URLROOT . '/vehicle/add_new']
                    );
                }
            }

            //? return json datas for error messages
            return $this->sendJsonResponse(
                STATUS_ERROR,
                'Validation Error',
                $cars->errors
            );
        }

        return $this->sendJsonResponse(
            STATUS_ERROR,
            'Unable to perform operation'
        );
    }

    public function edit_vehicle()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || $this->jsonData) {
            $cars = new Cars();
            $formDatas = $_POST;

            //? Validate car datas
            $validated = $cars->validate($formDatas, 'editVehicle');

            if ($validated) {
                $formDatas = (object) $formDatas;

                //? check if files is not empty
                if (!empty($_FILES)) {
                    //? upload image 
                    $imageUpload = upload_image($_FILES, 500, 500, 'car_images');

                    //? if image fails to upload
                    if (!$imageUpload) return $this->sendJsonResponse(
                        STATUS_ERROR,
                        'Unable to update image'
                    );

                    //? unlink previous image
                    unlinkImage($formDatas->old_image);

                    $formDatas->image = $imageUpload;
                }

                //? link to uploaded image


                //? insert new car details
                $updatedVehicle = $cars->update($formDatas->id, [
                    'vehicle_model' => $formDatas->vehicle_model,
                    'vehicle_number' => $formDatas->vehicle_number,
                    'seating_capacity' => $formDatas->seating_capacity,
                    'rent_per_day' => $formDatas->rent_per_day,
                    'image_url' => $formDatas->image,
                ]);


                if ($updatedVehicle) {
                    $_SESSION['car_update'] = "Car Updated Successfully";

                    //? return a success json
                    return $this->sendJsonResponse(
                        STATUS_SUCCESS,
                        'Car Updated Successfully',
                        ['redirectLink' =>  URLROOT . '/vehicle/add_new']
                    );
                }
            }

            //? return json datas for error messages
            return $this->sendJsonResponse(
                STATUS_ERROR,
                'Validation Error',
                $cars->errors
            );
        }
    }

    public function get_vehicle(string $carID)
    {
        $car = new Cars();
        $fetchCar = $car->where('car_id', $carID)[0];

        //? send data to frontend
        $data['car'] = $fetchCar;

        if ($fetchCar) {
            $this->sendJsonResponse(
                STATUS_SUCCESS,
                'Vehicle Retrieved Successfully',
                $data
            );
        } else {
            $this->sendJsonResponse(
                STATUS_ERROR,
                'Unable to get vehicle'
            );
        }
    }
}
