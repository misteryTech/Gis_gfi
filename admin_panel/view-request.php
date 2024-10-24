<?php
include("header.php");

// Fetch all students from the database
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



// Fetch the passed student_id and year_level from the URL
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$year_level = isset($_GET['year']) ? intval($_GET['year']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$query = "SELECT G.*,S.*



FROM grades AS G
INNER JOIN subjects AS S ON G.subject_id = S.id

 WHERE G.student_id = '$id'";
$result = mysqli_query($conn, $query);



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
                        <li><a class="dropdown-item" href="encoder-manage.php">Manage Encoder</a></li>
                        <li><a class="dropdown-item" href="manage-list-encoders.php">Encoders List</a></li>
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                    </ul>


                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Student ID: <?php echo $student_id; ?> <br><span class="underline">Year: <?php echo $year_level; ?></span></h2>
                <?php echo $id; ?> 
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="studentsTable">
                    <thead>
                        <tr>
               
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Year Level</th>
                            <th>Semester</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                     
                               echo "<td>" . htmlspecialchars($row['subject_code']) . "</td>";
                              
                               echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['unit']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                               echo "<td>
                                       <a class='btn btn-success btn-sm' href='student-profile.php?student_id=" . htmlspecialchars($row['id']) . "'>Completed</a>
                                       <button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'>Reject</button>
                                     </td>";
                               echo "</tr>";
                           }
                       } else {
                           echo "<tr><td colspan='6' class='text-center'>No Grades found</td></tr>";
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
            text: "Once deleted, you will not be able to recover this student's data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'delete-student.php',
                    type: 'POST',
                    data: {id: studentId},
                    success: function(response) {
                        swal("Student has been deleted!", {
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
