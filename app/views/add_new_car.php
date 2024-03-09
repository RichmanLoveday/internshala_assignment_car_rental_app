<?php

use app\models\Auth;

include("includes/header.php"); ?>

<body style="background: <?= BGCOLOR ?>;  margin-top: 5%;">
    <?php include("includes/navBar.php"); ?>
    <div class="container py-4 py-lg-6 my-5">
        <div>
            <button class="btn btn-success btn-lg my-3 float-end" onclick="clear_all_inputs()" data-bs-toggle="modal" href="#addNewCar" role="button">Add New Car <i class="fa fa-plus ms-1" aria-hidden="true"></i></button>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Vehicle Model</th>
                        <th scope="col">Vehicle Number</th>
                        <th scope="col">Seating Capacity</th>
                        <th scope="col">Rent Per Day</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <!---Loop through agency cars -->
                    <?php if (is_array($agencyCars) && count($agencyCars) > 0) :
                        //? for indexing
                        $sn = 0;
                    ?>
                        <?php foreach ($agencyCars as $car) : ?>
                            <tr>
                                <th scope="row"><?= ++$sn ?></th>
                                <td class=" p-3"><img style="width: 50px; height:50px;" src="<?= UPLOADS . $car->image_url; ?>" class=" border border-1" alt="<?= $car->vehicle_modal ?>"></td>
                                <td class=" p-3"><?= $car->vehicle_model ?></td>
                                <td class=" p-3"> <?= $car->vehicle_number ?></td>
                                <td class=" p-3"><?= $car->seating_capacity ?></td>
                                <td class=" p-3">
                                    <img style="width: 16px; height:16px; margin-top: -3px;" src="<?= NAIRA_ICON ?>" alt="naira_icon">
                                    <?= $car->rent_per_day ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" href="#addNewCar" role="button" onclick="get_vehicle_details_by_id('<?= $car->car_id ?>')">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <center>
                            No cars found
                        </center>
                    <?php endif ?>

                </tbody>
        </div>
    </div>

    <?php include('includes/modal.php'); ?>
    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            //? show success messgae on car insertion
            <?php if (isset($_SESSION['car_update'])) { ?>
                toaster('success', "<?= $_SESSION['car_update'] ?>");
            <?php  } ?>
        });

        function clear_all_inputs() {
            $('.input-value').val('');
            $('.errorField').text('');

            //? show add new vehicle text
            $('#add_new_vehicle_text').css('display', 'block');
            $('#edit_vehicle_text').css('display', 'none');

            //? show or hide submit buttons
            $('#add_new_car_btn').css('display', 'block');
            $('#edit_car_btn').css('display', 'none');
        }

        function validate_input(event, type = 'addNew') {
            event.preventDefault();

            //? selected input fields
            let vehicle_model = $('#vehicle_model');
            let vehicle_number = $('#vehicle_number');
            let seating_capacity = $('#seating_capacity');
            let image = $('#image');
            let rent_per_day = $('#rent_per_day');

            let error = false;

            //? attach files in form data
            let formData = new FormData();
            let allowedExtensions = /(\.jpeg|\.jpg|\.png)$/i;

            if (!vehicle_model.val()) {
                let errorMsgCon = vehicle_model.siblings("p");
                errorMsgCon.show();
                errorMsgCon.text('Please enter your first name');

            } else {
                vehicle_model.siblings('p').text('').hide();
                formData.append('vehicle_model', vehicle_model.val());
            }

            if (!vehicle_number.val()) {
                let errorMsgCon = vehicle_number.siblings("p");
                errorMsgCon.show();
                errorMsgCon.text('Please enter your last name');

            } else {
                vehicle_number.siblings('p').text('').hide();
                formData.append('vehicle_number', vehicle_number.val());
            }

            if (!seating_capacity.val()) {
                seating_capacity.siblings('p').show().text('Please enter your seating capacity');
                error = true;

            } else {
                seating_capacity.siblings('p').hide().text();
                formData.append('seating_capacity', seating_capacity.val());
            }

            if (!rent_per_day.val()) {
                rent_per_day.siblings('p').show().text('Please enter your rent_per_day');
                error = true;
            } else {
                rent_per_day.siblings('p').text('').hide();
                formData.append('rent_per_day', rent_per_day.val());
            }


            //? check if adding new add vehicle
            if (type == 'addNew') {
                if (image.get(0).files.length === 0) {
                    image.siblings('p').show().text("Please select a file.");
                    error = true;
                } else if (allowedExtensions.exec(image)) {
                    image.siblings('p').show().text("Please select a file.");
                    error = true;
                } else {
                    image.siblings('p').hide().text('');
                    formData.append('image', image[0].files[0]);
                }
            }

            //? check if updating previous vehicle
            if (type == "editVehicle") {
                if (image.get(0).files.length === 0) {
                    //? attach old image
                    formData.append('image', $('#old_image').val());

                } else if (allowedExtensions.exec(image)) {
                    image.siblings('p').show().text("Please select a file.");
                    error = true;
                } else {
                    image.siblings('p').hide().text('');
                    formData.append('image', image[0].files[0]);
                }
            }


            // Submit data to backend
            if (!error) {
                $('#add_new_car').prop('disabled', true);
                $('#add_new_car').children('span').hide();
                $('#add_new_car').children('div').show();

                if (type == 'addNew') submitData(formData);
                if (type == 'editVehicle') {
                    formData.append('id', $('#car_id').val())
                    formData.append('old_image', $('#old_image').val())
                    submitEditedData(formData)
                };
            }

        }


        //? submit data to backend
        function submitData(data) {
            $.ajax({
                url: "<?= URLROOT ?>/vehicle/add_new_car",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    console.log(res);
                    const data = $.parseJSON(res);
                    console.log(data.status);
                    if (data.status == 'error') {
                        $.each(data.data, (key, val) => {
                            //? display the error message based on error
                            console.log(key)
                            $(`#${key}`).siblings('p').show().text(val);
                        });

                        $('#submit_btn').prop('disabled', false);
                        $('#submit_btn').children('span').show();
                        $('#submit_btn').children('div').hide();
                    }

                    if (data.status == 'success') {
                        $('#submit_btn').prop('disabled', true);
                        $('#submit_btn').children('span').hide();
                        $('#submit_btn').children('div').show();

                        clear_all_inputs();

                        window.location.href = data.data.redirectLink;
                    }
                },
                error: () => {
                    console.error('POST request failed.');
                }
            })
        }


        //? submit edited data to backend
        function submitEditedData(data) {
            $.ajax({
                url: "<?= URLROOT ?>/vehicle/edit_vehicle",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    console.log(res);
                    const data = $.parseJSON(res);
                    console.log(data.status);
                    if (data.status == 'error') {
                        $.each(data.data, (key, val) => {
                            //? display the error message based on error
                            console.log(key)
                            $(`#${key}`).siblings('p').show().text(val);
                        });

                        $('#submit_btn').prop('disabled', false);
                        $('#submit_btn').children('span').show();
                        $('#submit_btn').children('div').hide();
                    }

                    if (data.status == 'success') {
                        $('#submit_btn').prop('disabled', true);
                        $('#submit_btn').children('span').hide();
                        $('#submit_btn').children('div').show();

                        clear_all_inputs();

                        window.location.href = data.data.redirectLink;
                    }
                },
                error: () => {
                    console.error('POST request failed.');
                }
            })
        }


        function get_vehicle_details_by_id(carID) {
            console.log(carID);
            $('#add_new_vehicle_text').css('display', 'none');
            $('#edit_vehicle_text').css('display', 'block');

            //? show edit button
            $('#add_new_car_btn').css('display', 'none');
            $('#edit_car_btn').css('display', 'block');


            $.ajax({
                url: `<?= URLROOT ?>/vehicle/get_vehicle/${carID}`,
                type: 'GET',
                contentType: 'application/json',
                success: function(res) {
                    console.log(res);
                    let data = $.parseJSON(res);

                    if (data.status == 'success') {
                        //? input values in different fields
                        let values = data.data.car;

                        $('#vehicle_model').val(values.vehicle_model)
                        $('#vehicle_number').val(values.vehicle_number);
                        $('#seating_capacity').val(values.seating_capacity);
                        $('#rent_per_day').val(values.rent_per_day);

                        //? field to store old image 
                        $('#old_image').val(values.image_url);

                        //? field to store car id
                        $('#car_id').val(values.id);
                    } else {
                        toaster('error', data.message);
                    }
                }
            })
        }
    </script>

</body>
<!-- Body End -->

</html>
<?php unset($_SESSION['car_update']); ?>