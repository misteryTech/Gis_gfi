<?php
include("header.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the student ID from the query parameter
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Fetch student details
$student = null;
if ($student_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Fetch subjects and units for dropdown
$subjects_result = mysqli_query($conn, "SELECT id, subject_name, unit FROM subjects");

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode Grades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php"><span>Grading System</span></a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                        <li><a class="dropdown-item" href="student_requirements.php">Requirements</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link active" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="sign_up.php">Sign up</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Encode Grades for Student</h3>

                <?php if ($student): ?>
                    <form  class="p-3 p-xl-4 form-floating" action="save-grades.php" method="post">
                        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">

                        <div class=" row mb-3">
                            <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control shadow" id="name" value="<?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <div class="col-md-6">
                            <label for="year_level" class="form-label">Year Level</label>
                            <input type="text" class="form-control shadow" id="year_level" value="<?php echo htmlspecialchars($student['year_level']); ?>" disabled>
                            </div>
                            <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <input type="text" class="form-control shadow" id="course" value="<?php echo htmlspecialchars($student['course']); ?>" disabled>
                            </div>


                        </div>



                        <!-- Subject and Grade Input -->
                        <h4 class="mt-4">Enter Grades</h4>
                        <div id="grades-container" class="form-row">
                            <div class="form-group">
                                <label for="subject" class="form-label">Select Subject</label>
                                <select class="form-select" id="subject" name="subject_id">
                                    <option value="">Select Subject</option>
                                    <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
                                        <option value="<?php echo htmlspecialchars($subject['id']); ?>">
                                            <?php echo htmlspecialchars($subject['subject_name']); ?> (<?php echo htmlspecialchars($subject['unit']); ?> units)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="grade" class="form-label">Grade</label>
                                <input type="number" class="form-control" id="grade" name="grade" min="0" max="100">
                            </div>
                            <div class="form-group align-self-end">
                                <button type="button" class="btn btn-secondary" id="add-grade-btn">Add Subject</button>
                            </div>
                        </div>
                        <div class="mt-3" id="additional-grades"></div>
                        <button type="submit" class="btn btn-primary mt-3">Save Grades</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">Student not found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#add-grade-btn').click(function() {
        var subject = $('#subject option:selected').text();
        var subject_id = $('#subject').val();
        var grade = $('#grade').val();

        if (subject_id && grade) {
            var html = '<div class="form-row mb-3">' +
                '<div class="form-group">' +
                '<label class="form-label">' + subject + '</label>' +
                '<input type="hidden" name="subject_ids[]" value="' + subject_id + '">' +
                '<input type="number" class="form-control" name="grades[]" value="' + grade + '" min="0" max="100" required>' +
                '</div>' +
                '</div>';

            $('#additional-grades').append(html);
            $('#subject').val('');
            $('#grade').val('');
        } else {
            alert('Please select a subject and enter a grade.');
        }
    });
});
</script>
</body>
</html>
