<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <section class="py-4 py-md-5 my-5">
        <div class="container py-md-5">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img class="img-fluid w-100" src="assets/img/illustrations/login.svg" alt="Login Illustration">
                </div>
                <div class="col-md-5 col-xl-4 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-5">
                        <span class="underline pb-1"><strong>Login</strong><br></span>
                    </h2>
                    <form id="loginForm" method="post" data-bs-theme="light">
                        <div class="mb-3">
                            <input class="shadow form-control" type="email" name="email" id="email" placeholder="Email" required>
                            <small id="emailError" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <input class="shadow form-control" type="password" name="password" id="password" placeholder="Password" required>
                            <small id="passwordError" class="text-danger"></small>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary shadow" type="submit">Log in</button>
                        </div>
                    </form>
                    <p class="text-muted">
                        <a href="forgotten-password.html">Forgot your password?</a>
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
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Clear previous errors
                $('#emailError').text('');
                $('#passwordError').text('');

                var email = $('#email').val().trim();
                var password = $('#password').val();

                // Validate form inputs
                var isValid = true;

                if (email === '') {
                    $('#emailError').text('Email is required.');
                    isValid = false;
                }

                if (password === '') {
                    $('#passwordError').text('Password is required.');
                    isValid = false;
                }

                if (!isValid) {
                    return; // Stop if there are validation errors
                }

                $.ajax({
                    url: 'login_process.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { email: email, password: password },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful',
                                text: 'Redirecting...',
                                timer: 1500,
                                timerProgressBar: true,
                                willClose: () => {
                                    window.location.href = 'admin_panel/dashboard.php'; // Redirect on success
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown); // Debug output
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            });
        });
    </script>
</body>
