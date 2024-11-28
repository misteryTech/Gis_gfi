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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="request_password.php">Request Password</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage-course.php">Manage Course</a></li>
                <li class="nav-item"><a class="nav-link" href="encoder-manage.php">Manage Encoder</a></li>
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
                <h2 class="display-6 fw-bold mb-4">Course <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register a new Course.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8 text-center">
                <!-- Aligned buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <button class="btn shadow mb-3" style="background-color: maroon; color: white;" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>
                    <a href="restore_course.php" class="btn btn-warning shadow mb-3">Archive Course</a>
                </div>

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
                <table class="table table-striped" id="coursesTable">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Department</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="courses-table-body">
                        <?php
                        // Fetching courses
                        $sql = "SELECT * FROM course_table WHERE status='unarchived'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['course_name']}</td>
                                    <td>{$row['department']}</td>
                                    <td>{$row['date_registered']}</td>
                                    <td>
                                        <div class='d-flex gap-2'>
                                            <button class='btn btn-success shadow edit-button' data-id='{$row['id']}' data-name='{$row['course_name']}' data-department='{$row['department']}'>Edit</button>
                                            <button class='btn btn-primary shadow archive-button' data-id='{$row['id']}' data-name='{$row['course_name']}'>Archive</button>
                                        </div>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No courses found</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Editing -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_course.php" method="post">
                    <input type="hidden" name="course_id" id="edit-course-id">
                    <div class="mb-3">
                        <label for="edit-course-name" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="edit-course-name" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="edit-department" name="department" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Confirmation -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to archive the course "<span id="courseNameToArchive"></span>"?
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
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    // Initialize DataTable
    $('#coursesTable').DataTable({
        order: [[2, 'desc']],
    });

    $(document).ready(function() {
        let courseIdToArchive;
        let courseNameToArchive;

        // Open Edit Modal
        $('.edit-button').click(function() {
            const courseId = $(this).data('id');
            const courseName = $(this).data('name');
            const department = $(this).data('department');

            $('#edit-course-id').val(courseId);
            $('#edit-course-name').val(courseName);
            $('#edit-department').val(department);

            $('#editCourseModal').modal('show');
        });

        // Open Archive Modal
        $('.archive-button').click(function() {
            courseIdToArchive = $(this).data('id');
            courseNameToArchive = $(this).data('name');

            $('#courseNameToArchive').text(courseNameToArchive);
            $('#archiveModal').modal('show');
        });

        // Confirm Archive
        $('#confirmArchiveButton').click(function() {
            $.ajax({
                url: 'archive_course.php',
                type: 'POST',
                data: { id: courseIdToArchive },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert("An error occurred while archiving the course.");
                }
            });
        });
    });
</script>
