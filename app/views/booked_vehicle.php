<?php

use app\models\Auth;

include("includes/header.php"); ?>

<body style="background: <?= BGCOLOR ?>; margin-top: 5%;">
    <?php include("includes/navBar.php"); ?>
    <div class="container py-4 py-lg-6 my-5">
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Booking ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Vehicle Image</th>
                        <th scope="col">Vehicle Model</th>
                        <th scope="col">Vehicle Number</th>
                        <th scope="col">Seating Capcity</th>
                        <th scope="col">Rent Days</th>
                        <th scope="col">Start Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($bookings) > 0) : $sn = 0; ?>
                    <?php foreach ($bookings as $book) : ?>
                    <tr>
                        <th scope="row"><?= ++$sn ?></th>
                        <td class=" p-3">1<?= $book->booking_id ?></td>
                        <td class=" p-3"><?= $book->first_name . ' ' . $book->last_name ?></td>
                        <td class=" p-3"><img style="width: 50px; height:50px;" src="<?= UPLOADS . $book->image_url ?>"
                                alt=""></td>
                        <td class=" p-3"><?= $book->vehicle_model ?></td>
                        <td class=" p-3"><?= $book->vehicle_number ?></td>
                        <td class=" p-3"><?= $book->seating_capacity ?></td>
                        <td class=" p-3"><img style="width: 16px; height:16px; margin-top: -3px;"
                                src="<?= NAIRA_ICON ?>" alt="naira_icon"><?= $book->rent_per_day ?></td>
                        <td class=" p-3"><?= $book->created_at ?></td>
                    </tr>
                    <?php endforeach ?>
                    <?php else : ?>
                    <center>
                        No bookings found
                    </center>
                    <?php endif; ?>

                </tbody>
        </div>
    </div>

    <?php include('includes/modal.php'); ?>
    <?php include('includes/scripts.php'); ?>

</body>
<!-- Body End -->

</html>