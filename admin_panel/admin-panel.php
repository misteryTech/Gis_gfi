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
                <a class="nav-link dropdown-toggle active" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administrator
                </a>
                <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                        <li><a class="dropdown-item" href="encoder-manage.php">Manage Encoder</a></li>
                        <li><a class="dropdown-item" href="manage-list-encoders.php">Encoders List</a></li>
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                    </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Students
                </a>
                <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                    <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                    <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                    <li><a class="dropdown-item" href="requirements.php">Requirements</a></li>
                </ul>
            </li>

            <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
            <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
            <?php if (isset($_SESSION['user_email'])): ?>
                <h2 class="display-6 fw-bold mb-4">Welcome <span class="underline"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span></h2>
                <?php endif; ?>
                          </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <form class="p-3 p-xl-4 form-floating" method="post" enctype="multipart/form-data" id="studentRegistrationForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="file" id="student-photo" name="student_photo" placeholder="Student Photo" required>
                        </div>
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="student-id" name="student_id" placeholder="Student ID" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="first-name" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="last-name" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select name="gender" id="gender" class="shadow form-control" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="phone-number" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input class="shadow form-control" type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">Course/Program Information</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select class="shadow form-control" id="year-level" name="year_level" required>
                                <option value="" disabled selected>Select Year Level</option>
                                <option value="first-year">First Year</option>
                                <option value="second-year">Second Year</option>
                                <option value="third-year">Third Year</option>
                                <option value="fourth-year">Fourth Year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="shadow form-control" id="course" name="course" required>
                                <option value="" disabled selected>Select Course</option>
                                <option value="bachelor-computer-science">BS Computer Science</option>
                                <option value="bachelor-information-technology">BS Information Technology</option>
                                <option value="bachelor-business-administration">BS Business Administration</option>
                                <option value="bachelor-nursing">BS Nursing</option>
                                <option value="bachelor-accountancy">BS Accountancy</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary shadow d-block w-100" name="student_registration" type="submit">Register</button>
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
    document.getElementById("studentRegistrationForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form from submitting

        var form = this;

        // Perform AJAX call to your PHP backend (or simulate successful registration)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "code.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Assuming a successful registration returns 200 status
                swal({
                    title: "Registration Successful!",
                    text: "Student has been successfully registered.",
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
