<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <style>
    {
            border-color: #ff4d4d; /* Border color when focused */
            box-shadow: 0 0 5px rgba(255, 77, 77, 0.5); /* Focus shadow */
        }

        .login-form button {
            background-color: #ff4d4d; /* Button color */
        }

        .login-form button:hover {
            background-color: #ff1a1a; /* Darker shade on hover */
        }
    </style>

    <section class="py-4 py-md-5 my-5 gradient-background" >
        <div class="container py-md-5">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img class="img-fluid w-100" src="picture/background.jpg" alt="Login Illustration">
                </div>
                <div class="col-md-5 col-xl-4 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-5">
                        <span class="underline pb-1"><strong>Login</strong><br></span>
                    </h2>
                    <form id="loginForm" method="post" data-bs-theme="light">
                        <div class="mb-3">
                            <input class="shadow form-control" type="text" name="id_no" id="id_no" placeholder="ID Number" required>
                            <small id="idNoError" class="text-danger"></small>
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
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var id_no = $('#id_no').val().trim(); // Ensure the value is properly trimmed
        var password = $('#password').val().trim(); // Ensure the value is properly trimmed

        // Basic validation
        if (id_no === '' || password === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'All fields are required.'
            });
            return; // Stop further execution if validation fails
        }

        $.ajax({
            url: 'student_process.php',
            type: 'POST',
            dataType: 'json',
            data: { id_no: id_no, password: password },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Redirecting...',
                        timer: 1500,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = 'student_panel/students_profile.php'; // Redirect on success
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
                    text: 'Something went wrong!'
                });
            }
        });
    });
});

    </script>
</body>
