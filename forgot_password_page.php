<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <style>
        /* Background Style */
        .gradient-background {
            background: url('picture/background.jpg'); /* Background Image */
            background-size: cover; /* Ensures the image covers the section */
            background-position: center center; /* Centers the image */
            padding: 6rem 0; /* Adds more padding for spacing */
        }

        /* Form Container Styling */
        .login-form {
            max-width: 450px; /* Set a max-width for the form */
            width: 100%; /* Ensure form takes full available width up to max-width */
            margin: 0 auto; /* Center the form horizontally */
            background: rgba(255, 255, 255, 0.85); /* Slight transparency for background */
            padding: 3rem; /* Padding for inner content */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        .login-form h2 {
            margin-bottom: 2rem; /* Margin for space below the heading */
            font-size: 2rem;
        }

        /* Input Field Styles */
        .login-form input, .login-form select {
            border: 1px solid #ccc; /* Border for inputs */
            margin-bottom: 1.5rem; /* Space between inputs */
            padding: 10px; /* Padding inside inputs */
            border-radius: 5px; /* Rounded corners for inputs */
            width: 100%;
        }

        /* Focus State for Inputs */
        .login-form input:focus, .login-form select:focus {
            border-color: #ff4d4d; /* Highlight border color */
            box-shadow: 0 0 5px rgba(255, 77, 77, 0.5); /* Focus shadow */
            outline: none;
        }

        /* Button Styles */
        .login-form button {
            background-color: #ff4d4d; /* Button background color */
            color: white; /* Text color */
            width: 100%; /* Full width button */
            padding: 12px; /* Button padding */
            border: none;
            border-radius: 5px; /* Rounded button edges */
            font-size: 1.1rem; /* Button text size */
        }

        /* Button Hover State */
        .login-form button:hover {
            background-color: #ff1a1a; /* Darker shade on hover */
            cursor: pointer; /* Pointer on hover */
        }

        /* Small Error Message */
        .login-form small {
            color: #ff4d4d;
            font-size: 0.875rem;
        }

        /* Responsive Design for Smaller Devices */
        @media (max-width: 768px) {
            .gradient-background {
                padding: 4rem 0; /* Adjust padding for smaller screens */
            }
            .login-form {
                padding: 2rem; /* Reduce padding on smaller screens */
                max-width: 350px; /* Slightly smaller form on mobile */
            }
            .login-form h2 {
                font-size: 1.5rem; /* Smaller heading font size on mobile */
            }
        }
    </style>

    <!-- Section with Gradient Background -->
    <section class="gradient-background">
        <div class="container py-md-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4">
                    <div class="login-form">
                        <h2 class="fw-bold mb-5 text-center">
                            <span class="underline pb-1"><strong>Password</strong></span>
                            <span class="underline pb-1"><strong>Reset</strong></span>
                        </h2>
                        <form id="passwordResetForm" method="post">
                            <div class="mb-3">
                                <input class="form-control shadow-sm" type="text" name="user_id" id="user_id" placeholder="Enter User ID" required>
                                <small id="user_idError" class="text-danger"></small>
                            </div>

                            <div class="mb-3">
                                <input class="form-control shadow-sm" type="email" name="email" id="email" placeholder="Enter your email" required>
                                <small id="emailError" class="text-danger"></small>
                            </div>

                            <!-- Dropdown for Role Selection -->
                            <div class="mb-3">
                                <select class="form-control shadow-sm" name="role" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                <small id="roleError" class="text-danger"></small>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-primary shadow-sm" type="submit">Contact Administrator</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <!-- Include jQuery and SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#passwordResetForm').on('submit', function(event) {
            event.preventDefault();

            // Clear previous errors
            $('#emailError').text('');
            $('#user_idError').text('');
            $('#roleError').text('');

            var email = $('#email').val().trim();
            var user_id = $('#user_id').val().trim();
            var role = $('#role').val().trim();

            // Validate inputs
            var isValid = true;

            if (user_id === '') {
                $('#user_idError').text('User ID is required.');
                isValid = false;
            }

            if (email === '') {
                $('#emailError').text('Email is required.');
                isValid = false;
            }

            if (role === '') {
                $('#roleError').text('Role is required.');
                isValid = false;
            }

            if (!isValid) {
                return; // Stop if validation fails
            }

            // Submit via AJAX
            $.ajax({
                url: 'password_reset_process.php',
                type: 'POST',
                dataType: 'json',
                data: { email: email, user_id: user_id, role: role },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Submitted',
                            text: response.message,
                            timer: 1500,
                            timerProgressBar: true
                        }).then(() => {
                            // Clear the form fields
                            $('#email').val('');
                            $('#user_id').val('');
                            $('#role').val('');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            });
        });
    </script>
</body>
