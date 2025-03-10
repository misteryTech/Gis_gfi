<?php include("header.php"); ?>

<body>
    <?php include("topnav.php"); ?>

    <style>
         /* Full-screen background with gradient */
         .gradient-background {
            background: url('picture/background.jpg') no-repeat center center; /* Background Image */
            background-size: cover; /* Ensure the image covers the section */
            height: 100vh; /* Full viewport height */
            display: flex; /* Use flexbox for vertical centering */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
        }

        /* Form Styling */
        .login-form {
            max-width: 400px; /* Limit the width of the form */
            width: 100%; /* Ensure form takes full available width up to max-width */
            background: rgba(255, 255, 255, 0.85); /* White background with slight transparency */
            padding: 2rem; /* Padding around the form */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25); /* Darker shadow to make the form stand out */
        }

        .login-form h2 {
            margin-bottom: 2rem; /* Space below the heading */
            text-align: center;
        }

        /* Input field styles */
        .login-form input {
            border: 1px solid #ccc; /* Border for inputs */
            padding: 10px;
            margin-bottom: 1.5rem; /* Space between inputs */
            border-radius: 5px; /* Rounded input borders */
            width: 100%; /* Full width inputs */
        }

        .login-form input:focus {
            border-color: #ff4d4d; /* Highlight the input when focused */
            box-shadow: 0 0 5px rgba(255, 77, 77, 0.5); /* Focus shadow */
            outline: none;
        }

        /* Button Styles */
        .login-form button {
            background-color: #ff4d4d; /* Button color */
            color: white; /* Button text color */
            width: 100%; /* Full width button */
            padding: 12px; /* Button padding */
            border: none;
            border-radius: 5px; /* Rounded button edges */
            font-size: 1.1rem; /* Button text size */
        }

        /* Button Hover State */
        .login-form button:hover {
            background-color: #ff1a1a; /* Darker shade on hover */
            cursor: pointer; /* Pointer cursor on hover */
        }

        /* Links */
        .login-form p a {
            color: #ff4d4d; /* Link color */
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline; /* Underline link on hover */
        }
    </style>

<section class="gradient-background">
        <div class="login-form">
            <h2 class="fw-bold mb-5">Login</h2>
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
            <p class="text-muted text-center">
                <a href="forgot_password_page.php">FORGOT PASSWORD?</a>
            </p>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <!-- Include jQuery and SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

document.addEventListener("DOMContentLoaded", function() {
    // Get the current page URL
    let currentPage = window.location.pathname.split("/").pop(); 

    // Hide the button if on student_login.php
    if (currentPage === "student_login.php") {
        document.getElementById("login-btn").style.display = "none";
    }
});


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
