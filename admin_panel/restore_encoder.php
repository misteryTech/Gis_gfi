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
                <h2 class="display-6 fw-bold mb-4">Archive <span class="underline">List</span></h2>
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

          
                            <th>Date Registered</th>
                            <th>Action</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $query = "SELECT * FROM encoder WHERE status='archived' ";
                        $result = mysqli_query($conn, $query);


                       if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               echo "<tr>";
                               echo "<td><img src='" . htmlspecialchars($row['encoder_photo']) . "' width='50'></td>";
                               echo "<td>" . htmlspecialchars($row['encoder_id']) . "</td>";
                               echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                          
                   
                               echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
                               echo "<td>
                               <button class='btn btn-success shadow archive-btn' data-id='{$row['encoder_id']}'>Restore</button>
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
    if (confirm("Are you sure you want to restore this encoder?")) {
        $.ajax({
            url: 'restore_encoder_process.php',
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
