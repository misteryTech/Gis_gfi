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
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">

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
                        <li><a class="dropdown-item" href="student_requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="request_grade_page.php">Request Grade</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="sign_up.php">Sign up</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Manage <span class="underline">Requests & Grades</span></h2>
                <p class="text-muted">View and handle students' requests and print student grades below.</p>
            </div>
        </div>

        <!-- Card Layout -->
        <div class="row d-flex justify-content-center">
            <!-- Student Request Card -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-center">
                        <h5 class="card-title">Student Request</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" data-bs-theme="light">
                            <div class="mb-3">
                                <input class="shadow form-control" type="text" id="student-name" name="student_name" placeholder="Student Name" required>
                            </div>
                            <div class="mb-3">
                                <input class="shadow form-control" type="email" id="student-email" name="student_email" placeholder="Student Email" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="shadow form-control" id="student-message" name="student_message" rows="4" placeholder="Request Details" required></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary shadow d-block w-100" type="submit">Submit Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Printed Student Grade Card -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header text-center">
                        <h5 class="card-title">Printed Student Grade</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" data-bs-theme="light">
                            <div class="mb-3">
                                <input class="shadow form-control" type="text" id="student-id" name="student_id" placeholder="Student ID" required>
                            </div>
                            <div class="mb-3">
                                <input class="shadow form-control" type="text" id="student-course" name="student_course" placeholder="Course/Program" required>
                            </div>
                            <div class="mb-3">
                                <input class="shadow form-control" type="text" id="semester" name="semester" placeholder="Semester" required>
                            </div>
                            <div>
                                <button class="btn btn-success shadow d-block w-100" type="submit">Print Grade</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
