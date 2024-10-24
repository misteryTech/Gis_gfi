<?php
include("header.php");

// Fetch all students from the database
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM grade_access_requests_db";
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
                <a class="nav-link dropdown-toggle active" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administrator
                </a>
                <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                    <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                    <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Students
                </a>
                <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                    <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                    <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                    <li><a class="dropdown-item" href="requirements.php">Requirements</a></li>
                </ul>
            </li>

            <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
            <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Student <span class="underline">List</span></h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="studentsTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Year Requested</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['date_request']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>
                                    <button class='btn btn-success btn-sm' onclick='acceptRequest(" . htmlspecialchars($row['student_id']) . ")'>Accept</button>
                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#rejectModal' data-id='" . htmlspecialchars($row['student_id']) . "'>Reject</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No students found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="reject-request.php" method="POST">
                        <div class="modal-body">
                          <input type="hidden" id="rejectRequestId" name="request_id">
                          <div class="form-group">
                            <label for="rejectReason">Reason for Rejection</label>
                            <textarea class="form-control" id="rejectReason" name="reject_reason" rows="3" required></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger">Reject Request</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
</section>

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

    // Accept request function
    function acceptRequest(requestId) {
        // Redirect to the accept-request.php page with the student ID
        window.location.href = "accept-request.php?id=" + requestId;
    }

    // Set the request ID in the reject modal when the Reject button is clicked
    $('#rejectModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var requestId = button.data('id'); // Extract the request ID from data-* attribute
        var modal = $(this);
        modal.find('#rejectRequestId').val(requestId); // Set the hidden input value
    });

    // Attach the acceptRequest function to global scope for the inline onclick event
    window.acceptRequest = acceptRequest;

});
</script>
