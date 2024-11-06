<?php 
include("header.php");
include("connection.php");
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
                <!-- Administrator Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                    </ul>
                </li>
                <!-- Manage Students Dropdown -->
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
                <!-- Additional Links -->
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>


<section class="py-5 mt-5">



    <div class="container py-5">

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Subject <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register a new subject.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">

                <!-- Subject Registration Form -->
                <form class="p-3 p-xl-4" method="post" id="subjectForm" action="subject_registration.php">
                    <div class="row mb-3">
                    <div class="col-md-4">
    <input class="shadow form-control" type="text" id="subject-code" name="subject_code" placeholder="Subject Code" required>
    <div id="subject-code-error" class="text-danger mt-1" style="display: none;"></div>
</div>



                        <div class="col-md-4">
                            <input class="shadow form-control" type="text" id="subject-name" name="subject_name" placeholder="Subject Name" required>
                        </div>
                        <div class="col-md-4">
                            <input class="shadow form-control" type="number" id="subject-units" name="subject_unit" placeholder="Subject Unit" min="0.01" step="0.01" required>
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <select class="shadow form-control" id="curriculum" name="curriculum" required>
                                <option value="" disabled selected>Select Curriculum</option>
                                <option value="New">New Curriculum</option>
                                <option value="Old">Old Curriculum</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="shadow form-control" id="courseSelect" name="course" required>
                                <option value="" disabled selected>Select Course</option>
                                <!-- Courses will be populated here dynamically -->
                                <?php
                                // Database connection
                    

                                // Fetching courses
                                $courseSql = "SELECT * FROM course_table ORDER BY course_name ASC"; // Adjust your table name accordingly
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

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>
                        <button class="btn btn-success shadow" id="submit_subject" name="submit_subject" type="submit">Register Subject</button>
                    </div>
                </form>

                <!-- Add Course Modal -->
                <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="course_registration.php" method="post" id="courseForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <input class="shadow form-control" type="text" id="course-name" name="course_name" placeholder="Course Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="shadow form-control" type="text" id="department" name="department" placeholder="Department" required>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-success shadow d-block w-100" name="submit_course" type="submit">Register Course</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            </div>
        </div>



        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="subjectsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Unit</th>
                            <th>Curriculum</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjects-table-body">
                        <?php
                        // Fetching subjects
                        $sql = "SELECT * FROM subjects WHERE archive='1'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['subject_code']}</td>
                                    <td>{$row['subject_name']}</td>
                                    <td>{$row['year']}</td>
                                    <td>{$row['semester']}</td>
                                    <td>{$row['unit']}</td>
                                    <td>{$row['curriculum']}</td>
                                    <td>{$row['course']}</td>
                                    <td>
                                        <button class='btn btn-primary shadow archive-button' data-id='{$row['id']}' data-name='{$row['subject_name']}'>Archive</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No subjects found</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Confirmation -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to archive the subject "<span id="subjectNameToArchive"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmArchiveButton">Archive</button>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let subjectIdToArchive;
        let subjectNameToArchive;

        // Open the modal when Archive button is clicked
        $('.archive-button').click(function() {
            subjectIdToArchive = $(this).data('id');
            subjectNameToArchive = $(this).data('name');
            
            // Set the subject name in the modal
            $('#subjectNameToArchive').text(subjectNameToArchive);
            $('#archiveModal').modal('show');
        });

        // Confirm archiving the subject
        $('#confirmArchiveButton').click(function() {
            $.ajax({
                url: 'archive_subject.php', // PHP file to handle archiving
                type: 'POST',
                data: { id: subjectIdToArchive },
                success: function(response) {
                    // Refresh the page or update the table after archiving
                    location.reload();
                },
                error: function() {
                    alert("An error occurred while archiving the subject.");
                }
            });
        });
    });
</script>
