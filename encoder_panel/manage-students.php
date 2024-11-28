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
                        <li><a class="dropdown-item" href="encoder_profile.php">Profile</a></li>
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
                <form class="p-3 p-xl-4 form-floating" action="code.php" method="post"  id="studentRegistrationForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="student-id" name="student_id" placeholder="Enter Student ID" title="Please enter a unique Student ID" required>
                            <small id="student-id-help" class="form-text text-muted">This ID must be unique for each student.</small>
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
                            <input class="shadow form-control" type="text" id="subject-course" name="course" placeholder="Course" value="<?php echo $course; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <select class="shadow form-control" id="student_status" name="student_status" required>
                                <option value="" disabled selected>Student Status</option>
                                <option value="Regular">Regular</option>
                                <option value="Irregular">Irregular</option>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('first-name').addEventListener('input', function (e) {
        const value = e.target.value;
        const namePattern = /^[A-Za-z]+$/;
        if (!namePattern.test(value)) {
            e.target.setCustomValidity("First Name must contain only letters.");
        } else {
            e.target.setCustomValidity("");
        }
    });

    document.getElementById('last-name').addEventListener('input', function (e) {
        const value = e.target.value;
        const namePattern = /^[A-Za-z]+$/;
        if (!namePattern.test(value)) {
            e.target.setCustomValidity("Last Name must contain only letters.");
        } else {
            e.target.setCustomValidity("");
        }
    });

    document.getElementById('student-id').addEventListener('blur', function (e) {
        const studentId = e.target.value;

        // Clear any existing notification
        const existingNotification = document.getElementById('student-id-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        if (studentId) {
            // AJAX to check if the student ID exists in the database
            $.ajax({
                url: 'check-student-id.php',
                method: 'POST',
                data: { student_id: studentId },
                success: function(response) {
                    if (response === 'exists') {
                        // Display the notification at the top of the form
                        const notification = document.createElement('div');
                        notification.id = 'student-id-notification';
                        notification.classList.add('alert', 'alert-danger', 'mt-3');
                        notification.innerText = 'Student ID already exists. Please use a different ID.';

                        // Insert the notification at the top of the form
                        const form = document.getElementById('studentRegistrationForm');
                        const firstRow = form.querySelector('.row');
                        form.insertBefore(notification, firstRow);

                        e.target.setCustomValidity("Student ID already exists. Please use a different ID.");
                    } else {
                        e.target.setCustomValidity(""); // Clear any previous custom validity
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);

                    // Display a generic error message if the AJAX request fails
                    const notification = document.createElement('div');
                    notification.id = 'student-id-notification';
                    notification.classList.add('alert', 'alert-danger', 'mt-3');
                    notification.innerText = 'Error checking Student ID. Please try again later.';

                    // Append the notification below the form
                    const form = document.getElementById('studentRegistrationForm');
                    form.appendChild(notification);

                    e.target.setCustomValidity("Error checking Student ID.");
                }
            });
        }
    });

    // Form Submission Validation
    document.getElementById('studentRegistrationForm').addEventListener('submit', function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>
