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
                <li class="nav-item"><a class="nav-link active" href="request_password.php">Request Password</a></li>
                <li class="nav-item"><a class="nav-link " href="manage-course.php">Manage Course</a></li>
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
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Forgot Password <span class="underline">Requests</span></h2>
                <p class="text-muted">Below are the requests for password resets made by users.</p>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
            <table class="table table-striped" id="resetRequestsTable">
    <thead>
        <tr>
            <th>User Id</th>
            <th>Email</th>
            <th>Request Date</th>
            <th>Request Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="reset-requests-table-body">
        <?php
        // Fetching all password reset requests
        $sql = "SELECT 
            *, 
            DATE(request_time) AS request_date, 
            TIME_FORMAT(TIME(request_time), '%h:%i %p') AS request_time_only 
        FROM password_reset_requests 
      ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['request_date']}</td> <!-- Display the date -->
                        <td>{$row['request_time_only']}</td> <!-- Display the time -->
                        <td>{$row['status']}</td>
                        <td>
                            <button class='btn btn-success shadow reset-status-button' data-id='{$row['id']}' data-status='{$row['status']}'>Update Status</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No password reset requests found.</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </tbody>
</table>

            </div>
        </div>
    </div>
</section>

<!-- Modal for Updating Reset Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Reset Request Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update_reset_status.php" method="post" id="statusForm">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <input type="hidden" id="resetRequestId" name="reset_request_id">
                    <div>
                        <button class="btn btn-success shadow d-block w-100" type="submit">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>

$('#resetRequestsTable').DataTable({
    order: [[3, 'desc']], // Orders by the first column (index 0) in descending order
    paging: true,        // Enables pagination
    searching: true,     // Enables searching
    responsive: true,    // Makes the table responsive
    language: {
        emptyTable: "No reset requests available.",
        search: "Search:",
        paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous"
        }
    }
});


    $(document).ready(function() {
        let resetRequestId;

        // Open the modal when "Update Status" button is clicked
        $('.reset-status-button').click(function() {
            resetRequestId = $(this).data('id');
            let status = $(this).data('status');
            
            // Set the current status in the modal
            $('#status').val(status);
            $('#resetRequestId').val(resetRequestId);
            $('#updateStatusModal').modal('show');
        });
    });
</script>
