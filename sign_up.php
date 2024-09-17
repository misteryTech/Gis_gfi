<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <section class="py-4 py-md-5 my-5">
        <div class="container py-md-5">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img class="img-fluid w-100" src="assets/img/illustrations/register.svg" alt="Register Illustration">
                </div>
                <div class="col-md-5 col-xl-4 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-5">
                        <span class="underline pb-1"><strong>Sign up</strong></span>
                    </h2>
                    <form id="registrationForm" method="post" data-bs-theme="light">
                        <div class="mb-3">
                            <input class="shadow-sm form-control" type="email" name="email" id="email" placeholder="Email" required>
                            <small id="emailError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <input class="shadow-sm form-control" type="password" name="password" id="password" placeholder="Password" required>
                            <small id="passwordError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <input class="shadow-sm form-control" type="password" name="password_repeat" id="password_repeat" placeholder="Repeat Password" required>
                            <small id="passwordRepeatError" class="text-danger"></small>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary shadow" type="submit">Create account</button>
                        </div>
                    </form>
                    <p class="text-muted">
                        Have an account?
                        <a href="login.php">Log in&nbsp;</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <!-- Include jQuery and SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       $(document).ready(function () {
    $('#registrationForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        let email = $('#email').val();
        let password = $('#password').val();
        let passwordRepeat = $('#password_repeat').val();
        let isValid = true;

        // Clear previous errors
        $('#emailError').text('');
        $('#passwordError').text('');
        $('#passwordRepeatError').text('');

        // Validate email
        if (email === '') {
            $('#emailError').text('Email is required.');
            isValid = false;
        } else if (!validateEmail(email)) {
            $('#emailError').text('Please enter a valid email.');
            isValid = false;
        }

        // Validate password
        if (password === '') {
            $('#passwordError').text('Password is required.');
            isValid = false;
        } else if (password.length < 6) {
            $('#passwordError').text('Password must be at least 6 characters long.');
            isValid = false;
        }

        // Validate password match
        if (password !== passwordRepeat) {
            $('#passwordRepeatError').text('Passwords do not match.');
            isValid = false;
        }

        // If all validations pass, submit the form via AJAX
        if (isValid) {
            $.ajax({
                url: 'register.php',
                type: 'POST',
                dataType: 'json',
                data: { email: email, password: password, password_repeat: passwordRepeat },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: response.message,
                            timer: 1500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'login.php'; // Redirect on success
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! ' + error
                    });
                }
            });
        }
    });

    // Function to validate email format
    function validateEmail(email) {
        let re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(String(email).toLowerCase());
    }
});

    </script>
</body>
