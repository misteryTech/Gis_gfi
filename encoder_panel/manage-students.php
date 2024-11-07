<?php
include("header.php");

// Assuming course is set when the user logs in
$course = $_SESSION['encoder_course']; // Replace with actual course data from user login


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
                        Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
               
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                        <li><a class="dropdown-item" href="request_grade_page.php">Request Grade</a></li>
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
                <h2 class="display-6 fw-bold mb-4">Student <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register as a student.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <form class="p-3 p-xl-4 form-floating" action="code.php" method="post" enctype="multipart/form-data" id="studentRegistrationForm">
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
                            <input class="shadow form-control" type="text" maxlength="11" id="phone-number" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input class="shadow form-control" type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="username" name="username" placeholder="Username" required>
                        </div>


                        <div class="col-md-6  position-relative">
    <input class="shadow form-control" type="password" id="password" name="password" placeholder="Password" required>
    <span class="toggle-password" onclick="togglePasswordVisibility()" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer;">
        👁️
    </span>
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
                        <input class="shadow form-control" type="text" id="subject-course" name="course"  placeholder="course" value="<?php echo $course; ?>" required>
            
                        </div>

       
                    



                        
                    </div>
                    <div class="col-md-12">
                            <select class="shadow form-control" id="student_status" name="student_status" required>
                                <option value="" disabled selected>Student Status</option>
                                <option value="Regular">Regular</option>
                                <option value="Irregular">Irregular</option>
               
                            </select>
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



</script>
