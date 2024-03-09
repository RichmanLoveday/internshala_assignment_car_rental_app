<?php $this->view("includes/header"); ?>

<body style="background: <?= BGCOLOR ?>">
    <div class="wrapper">
        <form class="form-right">
            <div class="alert alert-danger message" style="display: none;"></div>
            <h2 class="text-uppercase">Login</h2>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label>Email</label>
                    <input type="email" onclick="clearInput(event, this)" class="input-field" id="email" name="email"
                        required>
                    <p class="text-danger fw-light"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label>Password</label>
                    <input type="password" onclick="clearInput(event, this)" name="password" id="password"
                        class="input-field">
                    <p class="text-danger fw-light"></p>
                </div>
            </div>
            <div class="form-field">
                <button id="submit_btn" onclick="validate(event)" type="submit" class="register">
                    <span class="mx-1">Login</span>
                    <div class="spinner-border spinner-grow-sm" style="display: none;" role="status">
                    </div>
                </button>
            </div>
            <a href="<?= URLROOT ?>/signup">Dont have an account, register</a>
        </form>
    </div>

    <?php $this->view("includes/scripts"); ?>

    <script>
    function validate(event) {
        event.preventDefault();
        console.log('Yyyyyyyyyyyy')
        //? hide error message on click
        $('.message').hide();
        $('.message').text('');

        let email = $('#email');
        let password = $('#password');

        let error = false;
        let formData = {};

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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

        //? Submit data to backend
        if (!error) {
            $('#submit_btn').prop('disabled', true);
            $('#submit_btn').children('span').hide();
            $('#submit_btn').children('div').show();

            submitData(formData);
        }

    }

    function submitData(data) {
        $.ajax({
            url: "<?= URLROOT ?>/login",
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            success: (res) => {
                let data = $.parseJSON(res);

                if (data.status == 'error') {
                    $('.message').show();
                    $('.message').text(data.message);

                    $('#submit_btn').prop('disabled', false);
                    $('#submit_btn').children('span').show();
                    $('#submit_btn').children('div').hide();
                }

                if (data.status == 'success') {
                    $('.message').hide();
                    $('.message').text('');

                    window.location.href = data.data.redirectLink;
                }
            },
            error: () => {
                console.error("Error reaching to data");
            }
        })
    }


    function clearInput(event, ele) {
        $(ele).siblings('p').hide().text('');
        $('.message').hide();
        $('.message').text('');
    }
    </script>
</body>

</html>
<!-- Html End -->