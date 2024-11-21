<?php
include("header.php");

include ("connection.php");

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
                <li class="nav-item"><a class="nav-link " href="encoder-manage.php">Manage Encoder</a></li>
                <li class="nav-item"><a class="nav-link " href="manage-list-encoders.php">Encoders List</a></li>

                <li class="nav-item"><a class="nav-link active" href="manage-list-student.php">Student List</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Student <span class="underline">List</span></h2>
                <a href="restore_student.php"><button class='btn btn-warning shadow '>Archive Student</button></a> 
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="studentsTable">
                    <thead>
                        <tr>
                   
                            <th>Student ID</th>
                            <th>Name</th>

                            <th>Year Level</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $query = "SELECT * FROM students WHERE status='unarchived'";
                        $result = mysqli_query($conn, $query);


                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                           
                               echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['year_level']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                               echo "<td>
                                <button class='btn btn-success shadow edit-btn' data-id='{$row['student_id']}' data-bs-toggle='modal' data-bs-target='#editStudentModal'>Profile</button>
                              <button class='btn btn-danger shadow archive-btn' data-id='{$row['student_id']}'>Archive</button>
                                     </td>";
                               echo "</tr>";
                           }
                       } else {
                           echo "<tr><td colspan='6' class='text-center'>No students found</td></tr>";
                       }
                       ?>

                          </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm">
                    <input type="hidden" id="edit-student-id" name="student_id">
                    <div class="mb-3">
                        <label for="edit-first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit-first-name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit-last-name" name="last_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-last-name" class="form-label">Student Status</label>
                        <input type="text" class="form-control" id="edit-status" name="status" required>
                    </div>


                    <div class="mb-3">
                        <label for="edit-last-name" class="form-label">Date Registered</label>
                        <input type="date" class="form-control" id="edit-date-registered" name="date_registered" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-student-gender" class="form-label">Gender</label>
                        <select class="form-control" id="edit-student-gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-student-phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="edit-student-phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-student-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-student-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-student-course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="edit-student-course" name="course" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-student-course" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit-student-username" name="username" required>
                    </div>

                    

                    <!-- Change Password Field -->
                    <div class="mb-3">
                        <label for="edit-student-password" class="form-label">Change Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit-student-password" name="password" placeholder="Enter new password">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#edit-student-password">Show</button>
                        </div>
                        <small class="form-text text-muted">Leave blank to keep the current password.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<!-- DataTables and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#studentsTable').DataTable();

    // Fetch Student Data for Editing
    $(document).on('click', '.edit-btn', function () {
        var studentId = $(this).data('id');

        $.ajax({
            url: 'get-student.php',
            type: 'POST',
            data: { id: studentId },
            success: function (response) {
                var student = JSON.parse(response);

                if (!student.error) {
                    $('#edit-student-id').val(student.student_id);
                    $('#edit-first-name').val(student.first_name);
                    $('#edit-last-name').val(student.last_name);
                    $('#edit-student-gender').val(student.gender);
                    $('#edit-student-phone').val(student.phone);
                    $('#edit-student-email').val(student.email);
                    $('#edit-student-course').val(student.course);
                    $('#edit-student-username').val(student.username);
                    $('#edit-status').val(student.student_status);
                    $('#edit-date-registered').val(student.date_registered);
                } else {
                    alert(student.error);
                }
            },
            error: function () {
                alert('Error fetching student details.');
            },
        });
    });


    // Toggle password visibility
    $(document).on('click', '.toggle-password', function () {
        const inputSelector = $(this).data('target');
        const inputField = $(inputSelector);
        const inputType = inputField.attr('type');

        if (inputType === 'password') {
            inputField.attr('type', 'text');
            $(this).text('Hide');
        } else {
            inputField.attr('type', 'password');
            $(this).text('Show');
        }
    });

    // Save Edited Student Data
    $('#editStudentForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'update-student.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                var result = JSON.parse(response);

                if (result.success) {
                    alert('Student updated successfully.');
                    $('#editStudentModal').modal('hide');
                    location.reload();
                } else {
                    alert(result.error);
                }
            },
            error: function () {
                alert('Error updating student.');
            },
        });
    });



    // Save Edited Student Data
    $('#editStudentForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'update-student.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                var result = JSON.parse(response);

                if (result.success) {
                    alert('Student updated successfully.');
                    $('#editStudentModal').modal('hide');
                    location.reload();
                } else {
                    alert(result.error);
                }
            },
            error: function () {
                alert('Error updating student.');
            },
        });
    });

    // Archive Student
    $(document).on('click', '.archive-btn', function () {
        var studentId = $(this).data('id');

        if (confirm('Are you sure you want to archive this student?')) {
            $.ajax({
                url: 'archive_student.php',
                type: 'POST',
                data: { id: studentId },
                success: function (response) {
                    var result = JSON.parse(response);

                    if (result.success) {
                        alert('Student archived successfully.');
                        location.reload();
                    } else {
                        alert(result.error);
                    }
                },
                error: function () {
                    alert('Error archiving student.');
                },
            });
        }
    });
});

</script>
