<?php

use app\models\Auth; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark text-white fixed-top">
    <div class="collapse navbar-collapse d-flex justify-content-between px-5" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-white" href="<?= URLROOT ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset(Auth::user()->user_type) && Auth::user()->user_type == AGENCY) : ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="<?= URLROOT ?>/vehicle/add_new">Add Vehicle</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-white" href="<?= URLROOT ?>/booking">Bookings</a>
            </li>
            <?php endif; ?>
        </ul>
        <div>
            <?php

            //? display logout when user is logged
            if (Auth::logged_in()) : ?>
            <span class="me-4">Welcome <?= Auth::user()->first_name . ' ' . Auth::user()->last_name ?></span>
            <a href="<?= URLROOT ?>/logout" class="btn btn-sm  btn-outline-primary mx-2 text-white px-3">Logout</a>
            <?php else : ?>
            <a href="<?= URLROOT ?>/login" class="btn btn-sm  btn-outline-primary mx-2 text-white px-3">Login</a>
            <a href="<?= URLROOT ?>/signup/customer" class="btn btn-sm btn-primary mx-2 px-2">Signup as customer</a>
            <a href="<?= URLROOT ?>/signup/agency" class="btn btn-sm btn-primary mx-2 px-2">Signup as agency</a>
            <?php endif; ?>

        </div>
    </div>
</nav>