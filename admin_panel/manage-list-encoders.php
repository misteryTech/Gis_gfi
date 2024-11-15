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
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    </ul>   
                </li>

             
                <li class="nav-item"><a class="nav-link " href="manage-course.php">Manage Course</a></li>
                <li class="nav-item"><a class="nav-link " href="encoder-manage.php">Manage Encoder</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage-list-encoders.php">Encoders List</a></li>

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
                            <th>Action</th>
                      
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
                               echo "<td><button class='btn btn-success shadow edit-btn' data-id='{$row['encoder_id']}' data-bs-toggle='modal' data-bs-target='#editencoderModal'>Edit Profile</button></td>";

                              
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
            <input type="text" class="form-control" max="11" id="edit-encoder-phone" name="phone">
          </div>
          <div class="mb-3">
            <label for="edit-encoder-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-encoder-email" name="email">
          </div>
          <div class="mb-3">
            <label for="edit-encoder-course" class="form-label">Course</label>
            <input type="text" class="form-control" id="edit-encoder-course" name="course">
          </div>

          <div class="mb-3">
            <label for="edit-encoder-username" class="form-label">Username</label>
            <input type="text" class="form-control" id="edit-encoder-username" name="username">
          </div>

          <div class="mb-3">
  <label for="edit-encoder-password" class="form-label">Password</label>
  <div class="input-group">
    <input type="password" class="form-control" id="edit-encoder-password" name="password">
    <button type="button" id="toggle-password" class="btn btn-outline-secondary">Show</button>
  </div>
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

$('#toggle-password').click(function() {
    const passwordInput = $('#edit-encoder-password');
    const button = $(this);
    
    if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        button.text('Hide'); // Change button text to "Hide"
    } else {
        passwordInput.attr('type', 'password');
        button.text('Show'); // Change button text back to "Show"
    }
});


   // Initialize DataTable
   $('#encodersTable').DataTable();

// Fetch encoder data into the edit modal
$('.edit-btn').click(function() {
    var encoderId = $(this).data('id');

    $.ajax({
        url: 'get_encoder_id.php',
        type: 'POST',
        data: { id: encoderId },
        success: function(response) {
            var encoder = JSON.parse(response);
            if (!encoder.error) {
                $('#edit-encoder-id').val(encoder.encoder_id);
                $('#edit-encoder-name').val(encoder.first_name + ' ' + encoder.last_name);
                $('#edit-encoder-gender').val(encoder.gender);
                $('#edit-encoder-phone').val(encoder.phone);
                $('#edit-encoder-email').val(encoder.email);
                $('#edit-encoder-course').val(encoder.course);
                $('#edit-encoder-username').val(encoder.username);
                $('#edit-encoder-password').val(encoder.password);
            } else {
                alert("Error loading encoder details");
            }
        }
    });
});

// Handle form submission for editing encoder
$('#editencoderForm').submit(function(event) {
    event.preventDefault();

    $.ajax({
        url: 'update-encoder.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var result = JSON.parse(response);
            if (result.success) {
                alert(result.success);
                $('#editencoderModal').modal('hide');
                location.reload();
            } else {
                alert(result.error);
            }
        }
    });
});

</script>
