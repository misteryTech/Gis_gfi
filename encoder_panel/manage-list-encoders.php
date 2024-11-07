<?php
include("header.php");

include ("connection.php");


$query = "SELECT * FROM encoder";
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
            Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
       
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                    </ul>


                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Student
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-student.php">Register student</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Student List</a></li>
                        <li><a class="dropdown-item" href="encoder_requirements.php">Requirements</a></li>
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
                <h2 class="display-6 fw-bold mb-4">Encoder <span class="underline">List</span></h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="encodersTable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Encoder ID</th>
                            <th>Name</th>

                          
                            <th>Course</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                               echo "<td><img src='" . htmlspecialchars($row['encoder_photo']) . "' width='50'></td>";
                               echo "<td>" . htmlspecialchars($row['encoder_id']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                          
                               echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                              
                           }
                       } else {
                           echo "<tr><td colspan='6' class='text-center'>No encoders found</td></tr>";
                       }
                       ?>

                          </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Edit encoder Modal -->
<div class="modal fade" id="editencoderModal" tabindex="-1" aria-labelledby="editencoderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editencoderModalLabel">Edit encoder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editencoderForm">
          <input type="hidden" id="edit-encoder-id" name="encoder_id">
          <div class="mb-3">
            <label for="edit-encoder-name" class="form-label">Name</label>
            <input type="text" class="form-control" id="edit-encoder-name" name="encoder_name">
          </div>
          <div class="mb-3">
            <label for="edit-encoder-gender" class="form-label">Gender</label>
            <select class="form-control" id="edit-encoder-gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit-encoder-phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="edit-encoder-phone" name="phone">
          </div>
          <div class="mb-3">
            <label for="edit-encoder-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-encoder-email" name="email">
          </div>
          <div class="mb-3">
            <label for="edit-encoder-course" class="form-label">Course</label>
            <input type="text" class="form-control" id="edit-encoder-course" name="course">
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
    $('#encodersTable').DataTable();

    // Fetch encoder data into the edit modal
    $('.edit-btn').click(function() {
        var encoderId = $(this).data('id');

        // Fetch encoder details using AJAX (replace `get-encoder.php` with your actual backend URL)
        $.ajax({
            url: 'get-encoder.php',
            type: 'POST',
            data: {id: encoderId},
            success: function(response) {
                var encoder = JSON.parse(response);
                $('#edit-encoder-id').val(encoder.id);
                $('#edit-encoder-name').val(encoder.first_name + ' ' + encoder.last_name);
                $('#edit-encoder-gender').val(encoder.gender);
                $('#edit-encoder-phone').val(encoder.phone);
                $('#edit-encoder-email').val(encoder.email);
                $('#edit-encoder-course').val(encoder.course);
            }
        });
    });

    // Delete encoder functionality
    $('.delete-btn').click(function() {
        var encoderId = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this encoder's data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: 'delete-encoder.php',
                    type: 'POST',
                    data: {id: encoderId},
                    success: function(response) {
                        swal("encoder has been deleted!", {
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
