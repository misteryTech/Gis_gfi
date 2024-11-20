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
                <li class="nav-item"><a class="nav-link active" href="manage-list-encoders.php">Encoders List</a></li>

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
                <h2 class="display-6 fw-bold mb-4">Encoder <span class="underline">List</span></h2>
               <a href="restore_encoder.php"><button class='btn btn-warning shadow '>Archive Encoder</button></a> 
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
                            <th>Date Registered</th>
                            <th>Action</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $query = "SELECT * FROM encoder WHERE status='unarchive' ";
                        $result = mysqli_query($conn, $query);


                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                               echo "<td><img src='" . htmlspecialchars($row['encoder_photo']) . "' width='50'></td>";
                               echo "<td>" . htmlspecialchars($row['encoder_id']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                          
                               echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
                               echo "<td>
                               <button class='btn btn-success shadow edit-btn' data-id='{$row['encoder_id']}' data-bs-toggle='modal' data-bs-target='#editencoderModal'>Profile</button>
                               <button class='btn btn-danger shadow archive-btn' data-id='{$row['encoder_id']}'>Archive</button>
                           </td>";

                              
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
        <form id="editencoderForm" method="">
          <input type="hidden" id="edit-encoder-id" name="encoder_id">
          <div class="mb-3">
            <label for="edit-encoder-firstname" class="form-label">Firstname</label>
            <input type="text" class="form-control" id="edit-encoder-firstname" name="firstname">
          </div>

          <div class="mb-3">
            <label for="edit-encoder-lastname" class="form-label">Lastname</label>
            <input type="text" class="form-control" id="edit-encoder-lastname" name="lastname">
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




<div class="mb-3">
  <label for="edit-encoder-password" class="form-label">Change Passwords</label>
  <div class="input-group">
    <input type="password" class="form-control" id="change-encoder-password" name="change_password">
    <button type="button" id="toggle-passwords" class="btn btn-outline-secondary">Show</button>
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

$(document).on('click', '.archive-btn', function () {
    var encoderId = $(this).data('id');
    if (confirm("Are you sure you want to archive this encoder?")) {
        $.ajax({
            url: 'archive_encoder.php',
            type: 'POST',
            data: { id: encoderId },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert(result.success);
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert(result.error); // Show error if any
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Unable to archive encoder. Please try again.");
            }
        });
    }
});



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


$('#toggle-passwords').click(function() {
    const passwordInput = $('#change-encoder-password');
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
   $('#encodersTable').DataTable({
    order: [[4, 'desc']], // Default sort by the third column (Score) in descending order
   });

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
                $('#edit-encoder-id').val(encoder.id);
                $('#edit-encoder-firstname').val(encoder.first_name);
                $('#edit-encoder-lastname').val(encoder.last_name);

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



$('#editencoderForm').submit(function(event) {
    event.preventDefault(); // Prevent default form submission

    // Send the form data via AJAX to update encoder information
    $.ajax({
        url: 'update-encoder.php',
        type: 'POST',
        data: $(this).serialize(), // Serialize form data
        success: function(response) {
            var result = JSON.parse(response); // Parse the response

            if (result.success) {
                alert(result.success);
                $('#editencoderModal').modal('hide'); // Close modal
                location.reload(); // Reload the page to show updated info
            } else {
                alert(result.error); // Show error if any
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Unable to update encoder details. Please try again.");
        }
    });
});

</script>
