<?php

namespace app\models;

use app\core\Model;

class Cars extends Model
{

    protected $table = 'cars';

    protected $allowedColumns = [
        'car_id ',
        'agency_id',
        'vehicle_model',
        'vehicle_number',
        'seating_capacity',
        'rent_per_day',
        'image_url',
        'created_at',
    ];

    protected $beforeInsert = [
        'car_id',
    ];

    protected $afterSelect = [
        'get_booked_car',
    ];

    protected $beforeUpdate = [];


    public function validate(array $data, string $type = NULL): bool
    {
        //? Validate vehicle model
        if (isset($data['vehicle_model'])) {
            if (empty($data['vehicle_model'])) {
                $this->errors['vehicle_model'] = 'Pls fill in this field';
            }
        }

        //? validate vehicle number
        if (isset($data['vehicle_number'])) {
            if (empty($data['vehicle_number'])) {
                $this->errors['vehicle_number'] = 'Pls fill in this field';
            } else if (!empty($data['vehicle_number'])) {

                //? check dublicate car number
                if (is_null($type)) {
                    $carNumber = $this->where('vehicle_number', $data['vehicle_number']);

                    //? if found
                    if (is_array($carNumber) && count($carNumber) > 0) {
                        $this->errors['vehicle_number'] = 'Car number already exist';
                    }
                }
            }
        }

        //? validate seating capacity
        if (isset($data['seating_capacity'])) {
            if (empty($data['seating_capacity'])) {
                $this->errors['seating_capacity'] = 'Pls fill in this field';
            }
        }

        //? validate rent per day
        if (isset($data['rent_per_day'])) {
            if (empty($data['rent_per_day'])) {
                $this->errors['rent_per_day'] = 'Pls fill in this field';
            }
        }

        //? validate image url
        if (isset($data['image_url'])) {
            if (empty($data['image_url'])) {
                $this->errors['image_url'] = 'Pls fill in this field';
            }
        }


        //? Checking if errors are empty
        if (empty($this->errors)) {
            return true;
        }

        return false;
    }


    //? genearate a car ID 
    public function car_id(array $data)
    {
        $data['car_id'] = random_string(30);

        while ($this->where('car_id', $data['car_id'])) {
            $data['car_id'] .= rand(10, 1000);
        }

        return $data;
    }


    //? get booked car for a specific seach
    public function get_booked_car(object $data)
    {
        $bookedCar = new Bookings();

        //? check if user id is set
        if (isset(Auth::user()->user_id)) {
            $data->bookedCar = $bookedCar->row_exist([
                'customer_id' => Auth::user()->user_id,
                'car_id' => $data->car_id,
            ]);

            //? if no booked car
            if (!$data->bookedCar) {
                $data->bookedCar = NULL;
            }
        }
        return $data;
    }
}
