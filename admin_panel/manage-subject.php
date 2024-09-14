<?php
include("header.php");
?>
<body>
<nav class="navbar navbar-expand-md fixed-top fixed-top navbar-shrink py-3" id="mainNav">
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
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
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
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="sign_up.php">Sign up</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Subject <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register a new subject.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <form class="p-3 p-xl-4" method="post" id="subjectForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="subject-code" name="subject_code" placeholder="Subject Code" required>
                        </div>
                        <div class="col-md-6">
                            <input class="shadow form-control" type="text" id="subject-name" name="subject_name" placeholder="Subject Name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select class="shadow form-control" id="year" name="year" required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="first-year">First Year</option>
                                <option value="second-year">Second Year</option>
                                <option value="third-year">Third Year</option>
                                <option value="fourth-year">Fourth Year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="shadow form-control" id="semester" name="semester" required>
                                <option value="" disabled selected>Select Semester</option>
                                <option value="first-semester">First Semester</option>
                                <option value="second-semester">Second Semester</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary shadow d-block w-100" name="submit_subject" type="submit">Register Subject</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table to display subjects -->
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-md-10">
                <table class="table table-bordered" id="subjects-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjects-table-body">
                        <!-- Results will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

<!-- SweetAlert JS -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load subjects into the table
    loadSubjects();

    // Handle form submission
    $('#subjectForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'handle-subject.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                swal({
                    title: "Subject Registered!",
                    text: "The subject has been successfully registered.",
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    $('#subjectForm')[0].reset();
                    loadSubjects();
                });
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "There was an error processing your request.",
                    icon: "error",
                    button: "OK",
                });
            }
        });
    });

    // Load subjects into the table
    function loadSubjects() {
        $.ajax({
            url: 'fetch-subject.php',
            method: 'GET',
            success: function(data) {
                $('#subjects-table-body').html(data);
            }
        });
    }

    // Handle edit and delete actions
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        // You can handle the edit functionality here, e.g., showing a modal or redirecting to an edit page
    });

    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "This will delete the subject.",
            icon: "warning",
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'delete-subject.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        swal({
                            title: "Deleted!",
                            text: "The subject has been deleted.",
                            icon: "success",
                            button: "OK",
                        }).then(function() {
                            loadSubjects();
                        });
                    },
                    error: function() {
                        swal({
                            title: "Error",
                            text: "There was an error processing your request.",
                            icon: "error",
                            button: "OK",
                        });
                    }
                });
            }
        });
    });
});
</script>
</body>
