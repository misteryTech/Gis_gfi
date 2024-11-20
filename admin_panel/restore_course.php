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
                    <a class="nav-link dropdown-toggle " href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    </ul>
                </li>



                <li class="nav-item"><a class="nav-link" href="request_password.php">Request Password</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage-course.php">Manage Course</a></li>
                <li class="nav-item"><a class="nav-link " href="encoder-manage.php">Manage Encoder</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-list-encoders.php">Encoders List</a></li>

                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
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
                <h2 class="display-6 fw-bold mb-4">Course <span class="underline">Registration</span></h2>
                <p class="text-muted">Please fill out the form below to register a new Course.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
    <div class="col-md-10 col-xl-8 text-center">
    
        
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
                        $sql = "SELECT * FROM course_table WHERE status='archive'";

                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['course_name']}</td>
                                    <td>{$row['department']}</td>
                                    <td>{$row['date_registered']}</td>
                               
                                    <td>
                                        <button class='btn btn-success shadow archive-button' data-id='{$row['id']}' data-name='{$row['course_name']}'>Restore</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No courses found</td></tr>";
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
   $('#coursesTable').DataTable(
    {
                order: [[2, 'desc']], // Default sort by the third column (Score) in descending order
            }
            
   );



    $(document).ready(function() {
        let courseIdToArchive;
        let courseNameToArchive;

        // Open the modal when Archive button is clicked
        $('.archive-button').click(function() {
            courseIdToArchive = $(this).data('id');
            courseNameToArchive = $(this).data('name');
            
            // Set the course name in the modal
            $('#courseNameToArchive').text(courseNameToArchive);
            $('#archiveModal').modal('show');
        });

        // Confirm archiving the course
        $('#confirmArchiveButton').click(function() {
            $.ajax({
                url: 'restore_course_process.php', // PHP file to handle archiving
                type: 'POST',
                data: { id: courseIdToArchive },
                success: function(response) {
                    // Refresh the page or update the table after archiving
                    location.reload();
                },
                error: function() {
                    alert("An error occurred while archiving the course.");
                }
            });
        });
    });
</script>
