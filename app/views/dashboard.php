<?php

use app\models\Auth;

include("includes/header.php"); ?>

<body style="background: <?= BGCOLOR ?>; margin-top: 100px;">
    <?php include("includes/navBar.php"); ?>
    <div class="container mt-sm-5" style="margin-top: 10%;">
        <div class="row mt-4">
            <?php if (is_array($cars) && count($cars) > 0) : ?>
                <?php foreach ($cars as $car) : ?>
                    <div class="col-md-3 my-2">
                        <div class="p-lg-4 p-4 shadow-sm border border-1">
                            <div class="mb-4">
                                <div class="mb-3">
                                    <img alt="" class="img-fluid w-100 h-100" src="<?= UPLOADS . $car->image_url ?>">
                                </div>
                                <div class="d-flex flex-column mb-2">
                                    <small class="my-1 fw-bold" editable="inline">Vehicle model:
                                        <?= $car->vehicle_model ?>
                                    </small>
                                    <small class="my-1 fw-bold" editable="inline">Vehicle Number:
                                        <?= $car->vehicle_number ?>
                                    </small>
                                    <small class="my-1 fw-bold" editable="inline">Seating capacity:
                                        <?= $car->seating_capacity ?>
                                    </small>
                                    <small class="my-1 fw-bold" editable="inline">Rent per day:
                                        <img style="width: 16px; height:16px; margin-top: -2px;" src="<?= NAIRA_ICON ?>" alt="naira_icon">
                                        <?= $car->rent_per_day ?>
                                    </small>
                                </div>
                                <div class="d-flex justify-content-around mt-2">
                                    <a class="btn btn-outline-primary" href="<?= URLROOT ?>/vehicle/find/<?= $car->car_id ?>" role="button">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>
    <?php else : ?>
        <center>
            No Car Uploaded
        </center>
    <?php endif; ?>
    </div>

    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            //? show success messgae on registration
            <?php if (isset($_SESSION['registered'])) { ?>
                toaster('success', "<?= $_SESSION['registered'] ?>");
            <?php  } ?>

            //? show success message on login
            <?php if (isset($_SESSION['loggedIn'])) { ?>
                toaster('success', "<?= $_SESSION['loggedIn'] ?>");
            <?php  } ?>
        });
    </script>

</body>
<!-- Body End -->

</html>
<?php
//? unset display messages
unset($_SESSION['registered']);
unset($_SESSION['loggedIn']);
?>