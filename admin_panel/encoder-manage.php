<?php
include("header.php");
?>
<body>
<nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <span>Grade Inquiry System</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="request_password.php">Request Password</a></li>
             
                <li class="nav-item"><a class="nav-link " href="manage-course.php">Manage Course</a></li>
                <li class="nav-item"><a class="nav-link active" href="encoder-manage.php">Manage Encoder</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-list-encoders.php">Encoders List</a></li>

                <li class="nav-item"><a class="nav-link" href="manage-list-student.php">Student List</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>
<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Encoder <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register as an encoder.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <form class="p-3 p-xl-4" method="post" enctype="multipart/form-data" id="encoderRegistrationForm">
                    <div class="row mb-3 align-items-center">
                        <label for="encoder-photo" class="col-md-4 col-form-label">Choose Profile Picture</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="file" id="encoder-photo" name="encoder_photo" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="encoder-id" class="col-md-4 col-form-label">Encoder ID</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="text" id="encoder-id" name="encoder_id" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="first-name" class="col-md-4 col-form-label">First Name</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="text" id="first-name" name="first_name" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="last-name" class="col-md-4 col-form-label">Last Name</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="text" id="last-name" name="last_name" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="gender" class="col-md-4 col-form-label">Gender</label>
                        <div class="col-md-8">
                            <select name="gender" id="gender" class="shadow form-control" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="phone-number" class="col-md-4 col-form-label">Phone Number</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="text" maxlength="11" id="phone-number" name="phone" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="email" class="col-md-4 col-form-label">Email</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="email" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="username" class="col-md-4 col-form-label">Username</label>
                        <div class="col-md-8">
                            <input class="shadow form-control" type="text" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="password" class="col-md-4 col-form-label">Password</label>
                        <div class="col-md-8 position-relative">
                            <input class="shadow form-control" type="password" id="password" name="password" required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">Course/Program Information</p>
                    <div class="row mb-3 align-items-center">
                        <label for="courseSelect" class="col-md-4 col-form-label">Course</label>
                        <div class="col-md-8">
                            <select class="shadow form-control" id="courseSelect" name="course" required>
                                <option value="" disabled selected>Select Course</option>
                                <!-- Populate courses dynamically -->
                                <?php
                                include("connection.php");
                                $courseSql = "SELECT * FROM course_table WHERE status='unarchived' ORDER BY date_registered DESC";
                                $courseResult = mysqli_query($conn, $courseSql);
                                if (mysqli_num_rows($courseResult) > 0) {
                                    while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                                        echo "<option value='{$courseRow['course_name']}'>{$courseRow['course_name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No courses available</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary shadow d-block w-100" name="encoder_registration" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include("footer.php");
?>

<!-- SweetAlert JS -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

document.getElementById('phone-number').addEventListener('input', function(e) {
    // Replace any non-numeric character with an empty string
    this.value = this.value.replace(/[^0-9]/g, '');
    
    // Enforce maxlength of 11 digits
    if (this.value.length > 11) {
        this.value = this.value.slice(0, 11);
    }
});




function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.querySelector(".toggle-password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.textContent = "🙈"; // Change icon to indicate visible password
    } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "👁️"; // Change icon back to indicate hidden password
    }
}



    document.getElementById("encoderRegistrationForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form from submitting

        var form = this;

        // Perform AJAX call to your PHP backend (or simulate successful registration)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "encoder-registration.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Assuming a successful registration returns 200 status
                swal({
                    title: "Registration Successful!",
                    text: "encoder has been successfully registered.",
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    form.submit(); // Submit form after alert
                });
            } else {
                swal({
                    title: "Registration Failed",
                    text: "There was an issue with the registration. Please try again.",
                    icon: "error",
                    button: "OK",
                });
            }
        };
        xhr.send(new FormData(form));
    });
</script>
