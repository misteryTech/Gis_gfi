<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <style>
        /* Full-Screen Background Style */
        .gradient-background {
            background: url('picture/background.jpg') no-repeat center center; /* Background Image */
            background-size: cover; /* Ensures the image covers the section */
            height: 100vh; /* Full viewport height */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
        }

        /* Form Container Styling */
        .login-form {
            max-width: 450px; /* Max width for form */
            width: 100%; /* Ensure form takes full available width up to max-width */
            background: rgba(255, 255, 255, 0.85); /* Slight transparency */
            padding: 3rem; /* Inner padding */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25); /* Strong shadow for floating effect */
        }

        .login-form h2 {
            margin-bottom: 2rem; /* Space below the heading */
            font-size: 2rem; /* Large heading */
            text-align: center; /* Centered heading */
        }

        /* Input Field Styles */
        .login-form input {
            border: 1px solid #ccc; /* Border for inputs */
            margin-bottom: 1.5rem; /* Space between inputs */
            padding: 10px; /* Padding inside inputs */
            border-radius: 5px; /* Rounded corners */
            width: 100%; /* Full width inputs */
        }

        /* Focus State for Inputs */
        .login-form input:focus {
            border-color: #ff4d4d; /* Highlight border color */
            box-shadow: 0 0 5px rgba(255, 77, 77, 0.5); /* Focus shadow effect */
            outline: none; /* Remove default outline */
        }

        /* Button Styling */
        .login-form button {
            background-color: #ff4d4d; /* Button background color */
            color: white; /* Text color */
            width: 100%; /* Full width button */
            padding: 12px; /* Button padding */
            border: none;
            border-radius: 5px; /* Rounded button edges */
            font-size: 1.1rem; /* Button text size */
        }

        /* Button Hover Effect */
        .login-form button:hover {
            background-color: #ff1a1a; /* Darker shade on hover */
            cursor: pointer; /* Pointer cursor */
        }

        /* Error Message Styling */
        .login-form small {
            color: #ff4d4d; /* Red color for error messages */
            font-size: 0.875rem; /* Smaller error text */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .gradient-background {
                padding: 4rem 0; /* Adjust padding for smaller screens */
            }
            .login-form {
                padding: 2rem; /* Reduce padding on smaller screens */
                max-width: 350px; /* Smaller form size for mobile */
            }
            .login-form h2 {
                font-size: 1.5rem; /* Smaller heading on mobile */
            }
        }
    </style>

    <!-- Full-Screen Section with Gradient Background -->
    <section class="gradient-background">
        <div class="login-form">
            <h2 class="fw-bold mb-5">
                <span class="underline pb-1"><strong>Administrator</strong></span><br>
                <span class="underline pb-1"><strong>Login</strong></span>
            </h2>
            <form id="loginForm" method="post" data-bs-theme="light">
                <div class="mb-3">
                    <input class="form-control shadow-sm" type="email" name="email" id="email" placeholder="Email" required>
                    <small id="emailError" class="text-danger"></small>
                </div>
                <div class="mb-3">
                    <input class="form-control shadow-sm" type="password" name="password" id="password" placeholder="Password" required>
                    <small id="passwordError" class="text-danger"></small>
                </div>
                <div class="mb-4">
                    <button class="btn btn-primary shadow-sm" type="submit">Log in</button>
                </div>
            </form>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <!-- Include jQuery and SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Prevent form submission

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
                    return; // Stop if validation errors exist
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
                                    if (response.redirect === 'encoder_panel/') {
                                        window.location.href = 'encoder_panel/encoder_profile.php'; // Redirect for encoder users
                                    } else {
                                        window.location.href = 'admin_panel/dashboard.php'; // Redirect for admin users
                                    }
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
                        console.error('AJAX error:', textStatus, errorThrown); // Debugging output
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
