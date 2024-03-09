<?php

namespace app\models;

use app\core\Model;

class Bookings extends Model
{

    protected $table = 'bookings';

    protected $allowedColumns = [
        'booking_id  ',
        'car_id',
        'customer_id',
        'no_of_days',
        'start_date',
        'end_date',
        'created_at',
    ];

    protected $beforeInsert = [
        'booking_id',
    ];

    protected $beforeUpdate = [];


    public function validate(array $data, string $type = NULL): bool
    {

        //? Validate no_of_days
        if (isset($data['no_of_days'])) {
            if ($data['no_of_days'] == 0) {
                $this->errors['no_of_days'] = 'Pls fill in this field';
            }
        }

        //? validate start_date 
        if (isset($data['start_date'])) {
            if (empty($data['start_date'])) {
                $this->errors['start_date'] = 'Pls fill in this field';
            }
        }


        //? Checking if errors are empty
        if (empty($this->errors)) {
            return true;
        }

        return false;
    }


    public function get_booked_vehicles(string $agency_id)
    {
        $this->query("SELECT * FROM bookings JOIN cars ON bookings.car_id = cars.car_id JOIN users ON bookings.customer_id = users.user_id WHERE cars.agency_id = :agency_id");
        $this->execute(['agency_id' => $agency_id]);

        if ($this->rowCount() > 0) {
            return $this->resultSet();
        }

        return [];
    }

    //? genearate a booking ID 
    public function booking_id(array $data)
    {
        $data['booking_id'] = random_string(30);

        while ($this->where('booking_id', $data['booking_id'])) {
            $data['booking_id'] .= rand(10, 1000);
        }

        return $data;
    }


    public function get_booked_user_details(object $data)
    {
        if (!isset($data->customer_id)) return $data;

        $customer = new User();
        $data->customer_id = $customer->where('user_id', $data->customer_id)[0];


        show($data);
        die;
        return $data;
    }
}
