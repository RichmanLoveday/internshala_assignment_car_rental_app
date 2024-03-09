<?php

use app\models\Auth;

include("includes/header.php"); ?>

<body style="background: <?= BGCOLOR ?>">
    <?php include("includes/navBar.php"); ?>
    <div class="container py-4 py-lg-6 my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="lc-block px-4">
                    <!--  If you want to remove px-4 please add overflow-hidden class to the section -->
                    <div class="position-relative">
                        <div class="lc-block position-absolute top-0 end-0 w-100 h-100 bg-dark mt-4 me-4"></div>

                        <img class="position-relative img-fluid" src="<?= UPLOADS . $car->image_url ?>" sizes="(max-width: 1080px) 100vw, 1080px" width="1080" height="1080" alt="Photo by Spacejoy" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="lc-block mb-4">
                    <div editable="rich">
                        <h2 class="fw-bold display-6">Vehicle Model: <?= $car->vehicle_model ?></h2>
                    </div>
                </div>
                <div class="lc-block mb-5">
                    <div editable="rich">
                        <div class="lead text-muted d-flex flex-column">
                            <small class="my-1">Vehicle Number: <?= $car->vehicle_number ?></small>
                            <small class="my-1">Seating Capacity: <?= $car->seating_capacity ?></small>
                            <small class="my-1">Rent Per Day: <img style="width: 16px; height:16px; margin-top: -3px;" src="<?= NAIRA_ICON ?>" alt="naira_icon">
                                <?= $car->rent_per_day ?>
                            </small>
                        </div>
                    </div>
                    <form action="<?= URLROOT ?>/booking/book_vehicle" class="mt-3" method="post">
                        <div class="mb-3">
                            <label>Select Number Of Days</label>
                            <select name="no_of_days" id="" class=" form-control">
                                <option value="0" class="">---Select Number of days----</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Select Start Date</label>
                            <input type="date" class="input-field form-control" name="start_date" value="<?= get_var('date') ?>">
                            <input type="text" hidden value="<?= $vehicleID ?>" name="car_id">
                            <input type="text" hidden value="<?= Auth::user()->user_id ?? '' ?>" name="customer_id">
                        </div>

                        <div>
                            <div class="p-2 mx-auto">
                                <button <?= (!isset($car->bookedCar) || is_null($car->bookedCar)) ? '' : 'disabled' ?> class="btn btn-lg btn-success mx-auto">Rent Car</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            //? show success messgae on registration
            <?php if (isset($_SESSION['access_error'])) { ?>
                toaster('error', "<?= $_SESSION['access_error'] ?>");
            <?php  } ?>

            //? show success messgae on booked
            <?php if (isset($_SESSION['booked'])) { ?>
                toaster('error', "<?= $_SESSION['booked'] ?>");
            <?php  } ?>

            //? show success messgae on booking error
            <?php if (isset($_SESSION['booking_error'])) { ?>
                toaster('error', "<?= $_SESSION['booking_error'] ?>");
            <?php  } ?>
        });
    </script>

</body>
<!-- Body End -->

</html>
<?php unset($_SESSION['access_error']);
unset($_SESSION['booking_error']);
unset($_SESSION['booked']);
?>