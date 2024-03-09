<?php $this->view("includes/header"); ?>

<body style="background: <?= BGCOLOR ?>">
    <div class="wrapper">
        <div class="form-left">
            <h2 class="text-uppercase">information</h2>
            <p>
                CruiseX is a cutting-edge car rental application designed to provide seamless and convenient access to a
                diverse fleet of vehicles for your travel needs. With an intuitive user interface and robust features,
                CruiseX offers an unparalleled rental experience for both customers and rental agencies.
            </p>
            <div class="form-field mb-3">

                <a href="<?= URLROOT ?>/login" class="btn btn-sm bg-white text-dark p-3 rounded rounded-start">Have an
                    Account?</a>

            </div>
            <a class="text-white link-underline fst-italic" href="<?= URLROOT ?>/signup/agency">Sign up as agency</a>
        </div>
        <form class="form-right" method="post">
            <h2 class="text-uppercase">Register as customer</h2>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" id="first_name" class="input-field">
                    <p class="text-danger fw-light"></p>
                </div>
                <div class="col-sm-6 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="input-field">
                    <p class="text-danger fw-light"></p>
                </div>
            </div>
            <div class="mb-3">
                <label>Your Email</label>
                <input type="email" class="input-field" name="email" id="email">
                <p class="text-danger fw-light"></p>
            </div>

            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="input-field">
                    <p class="text-danger fw-light"></p>
                </div>
                <div class="col-sm-6 mb-3">
                    <label>Current Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="input-field">
                    <p class="text-danger fw-light"></p>
                </div>
            </div>
            <div class="form-field">
                <button id="submit_btn" onclick="validate(event)" type="button" class="register">
                    <span class="mx-1">Register</span>
                    <div class="spinner-border spinner-grow-sm" style="display: none;" role="status">
                    </div>
                </button>
            </div>
        </form>
    </div>


    <?php $this->view("includes/scripts"); ?>
    <!-- <script src="<?= ASSETS ?>/js/signup.js"></script> -->

    <script>
        function validate(event) {
            event.preventDefault();

            let email = $('#email');
            let first_name = $('#first_name');
            let last_name = $('#last_name');

            let password = $('#password');
            let confirm_password = $('#confirm_password');

            let error = false;
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            let formData = {};

            if (!first_name.val()) {
                let errorMsgCon = first_name.siblings("p");
                errorMsgCon.show();
                errorMsgCon.text('Please enter your first name');

            } else {
                first_name.siblings('p').text('').hide();
                formData.first_name = first_name.val();
            }

            if (!last_name.val()) {
                let errorMsgCon = last_name.siblings("p");
                errorMsgCon.show();
                errorMsgCon.text('Please enter your last name');

            } else {
                last_name.siblings('p').text('').hide();
                formData.last_name = last_name.val();
            }

            if (!email.val()) {
                email.siblings('p').show().text('Please enter your email');
                error = true;

            } else if (!emailRegex.test(email.val())) {
                email.siblings('p').show().text('Please enter a valid email @');
                error = true;

            } else {
                email.siblings('p').hide().text();
                formData.email = email.val();
            }

            if (!password.val()) {
                password.siblings('p').show().text('Please enter your password');
                error = true;
            } else {
                password.siblings('p').text('').hide();
                formData.password = password.val();
            }

            if (confirm_password.val() !== password.val()) {
                confirm_password.siblings('p').show().text('Password does not match');
                error = true;
            } else {
                confirm_password.siblings('p').text('').hide();
                formData.confirm_password = confirm_password.val();
            }


            // Submit data to backend
            if (!error) {
                $('#submit_btn').prop('disabled', true);
                $('#submit_btn').children('span').hide();
                $('#submit_btn').children('div').show();
                formData.user_type = 'customer';

                submitData(formData);
            }

        }


        //? submit to server
        function submitData(data) {
            console.log(data);
            $.ajax({
                url: "<?= URLROOT ?>/signup/submit_registration",
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: (res) => {
                    const data = $.parseJSON(res);
                    if (data.status == 'error') {
                        $.each(data.data.error, (key, val) => {
                            // display the error message based on error
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

                        //? direct to dashboard
                        window.location.href = data.data.redirectLink;
                    }
                },
                error: () => {
                    console.error('POST request failed.');
                }
            })
        }
    </script>

</body>
<!-- Body End -->

</html>
<!-- Html End -->