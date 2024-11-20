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
                <h2 class="display-6 fw-bold mb-4">Archive <span class="underline">List</span></h2>
      
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


                        $query = "SELECT * FROM students WHERE status='archive'";
                        $result = mysqli_query($conn, $query);


                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                           
                               echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['year_level']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                               echo "<td>
                                   
                                       <button class='btn btn-success btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'>Restore</button>
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

<!-- Edit Student Modal -->
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
            <label for="edit-student-name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit-student-name" name="student_name">
          </div>
          <div class="mb-3">
            <label for="edit-student-gender" class="form-label">Gender</label>
            <select class="form-control" id="edit-student-gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit-student-phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="edit-student-phone" name="phone">
          </div>
          <div class="mb-3">
            <label for="edit-student-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-student-email" name="email">
          </div>
          <div class="mb-3">
            <label for="edit-student-course" class="form-label">Course</label>
            <input type="text" class="form-control" id="edit-student-course" name="course">
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
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
$(document).ready(function() {
    // Initialize DataTable
    $('#studentsTable').DataTable();

    // Fetch student data into the edit modal
    $('.edit-btn').click(function() {
        var studentId = $(this).data('id');

        // Fetch student details using AJAX (replace `get-student.php` with your actual backend URL)
        $.ajax({
            url: 'get-student.php',
            type: 'POST',
            data: {id: studentId},
            success: function(response) {
                var student = JSON.parse(response);
                $('#edit-student-id').val(student.id);
                $('#edit-student-name').val(student.first_name + ' ' + student.last_name);
                $('#edit-student-gender').val(student.gender);
                $('#edit-student-phone').val(student.phone);
                $('#edit-student-email').val(student.email);
                $('#edit-student-course').val(student.course);
            }
        });
    });

    // Delete student functionality
    $('.delete-btn').click(function() {
        var studentId = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "You want to restore this data",
            icon: "success",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'restore-student-progress.php',
                    type: 'POST',
                    data: {id: studentId},
                    success: function(response) {
                        swal("Student has been restored!", {
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
});
</script>
