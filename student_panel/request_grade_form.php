<?php
include("header.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the student ID from the session
$student_id = $_SESSION['student_id'];
$id = $_SESSION['id'];

// Fetch grade requests from the database
$grade_requests = [];
if ($student_id) {
    $query = "SELECT id, year, status, date_request 
              FROM grade_access_requests_db 
              WHERE student_id = '$student_id' 
              ORDER BY date_request DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $grade_requests[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Grades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .encoded-grades-table th {
            background-color: #9C1414;
            color: white;
            text-align: center;
        }

        .encoded-grades-table td {
            text-align: center;
        }

        .no-requests {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include("navbar.php"); ?>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h2 class="mb-4">Request Grade Form</h2>
                <form action="process/submit_grade_request.php" method="POST">
                    <div class="form-row mb-3">
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $student_id; ?>" name="student_id">
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <label for="year">Select Year:</label>
                            <select class="form-control" name="year" id="year" required>
                                <option value="">--Select Year--</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Request Grades</button>
                </form>

                <h3 class="mt-5">Your Grade Requests</h3>
                <table class="table table-bordered encoded-grades-table mt-3">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Request Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grade_requests)): ?>
                            <?php foreach ($grade_requests as $request): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($request['id']); ?></td>
                                    <td><?php echo htmlspecialchars($request['year']); ?></td>
                                    <td><?php echo ucfirst(htmlspecialchars($request['status'])); ?></td>
                                    <td><?php echo htmlspecialchars($request['date_request']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-requests">No grade requests found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.encoded-grades-table').DataTable();
    });
</script>
</body>
</html>
