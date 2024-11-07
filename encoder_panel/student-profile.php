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

// Fetch encoded encoded_grades with textual year converted to numeric values
$encoded_encoded_grades_result = mysqli_query($conn, "
    SELECT subjects.subject_name, encoded_grades_table.grade, subjects.subject_code, subjects.year, subjects.semester AS semester, subjects.unit,
           CASE
               WHEN subjects.year = 'first-year' THEN 1
               WHEN subjects.year = 'second-year' THEN 2
               WHEN subjects.year = 'third-year' THEN 3
               WHEN subjects.year = 'fourth-year' THEN 4
               ELSE 0
           END AS numeric_year
    FROM encoded_grades_table
    JOIN subjects ON encoded_grades_table.subject_id = subjects.id
    WHERE encoded_grades_table.student_id = $student_id
    ORDER BY semester ASC
");

mysqli_close($conn);

// Prepare data for tab pills
$encoded_grades_by_year = [];
while ($grade = mysqli_fetch_assoc($encoded_encoded_grades_result)) {
    $year = $grade['numeric_year'];
    if (!isset($encoded_grades_by_year[$year])) {
        $encoded_grades_by_year[$year] = [];
    }
    $encoded_grades_by_year[$year][] = $grade;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode encoded_grades</title>
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
        .encoded-encoded_grades-table th, .encoded-encoded_grades-table td {
            text-align: center;
   
        }

        .btn-primarys{
            background-color: green;
            color: white;
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
                    Encoder
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
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link " href="encode-encoded_grades.php">Encode encoded grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5" id="printSection">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Student Profile</h3>

                <?php if ($student): ?>
                    <div class="student-details mb-4">
                        <div class="row align-items-center">
                            <!-- Student Photo -->
                            <div class="col-md-5">
                                <img src="<?php echo htmlspecialchars($student['student_photo']); ?>" alt="Student Image" class="img-fluid rounded">
                            </div>

                            <!-- Student Info -->
                            <div class="col-md-7">
                                <h4><strong>ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></h4>
                                <h4><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h4>
                                <p><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></p>
                                <p><strong>Contact Info (Phone):</strong> <?php echo htmlspecialchars($student['phone']); ?></p>
                                <p><strong>Contact Info (Email):</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                                <p><strong>Year Level:</strong> <?php echo htmlspecialchars($student['year_level']); ?></p>
                                <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primarys btn-sm" href="print_encoded_grades.php?student_id=<?php echo htmlspecialchars($student['id']); ?>">Print encoded_grades</a>
                    <h4 class="mt-5">Encoded encoded_grades</h4>
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <?php for ($year = 1; $year <= 4; $year++): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo ($year == 1) ? 'active' : ''; ?>" id="pills-year<?php echo $year; ?>-tab" data-bs-toggle="pill" href="#pills-year<?php echo $year; ?>" role="tab" aria-controls="pills-year<?php echo $year; ?>" aria-selected="<?php echo ($year == 1) ? 'true' : 'false'; ?>">
                                    Year <?php echo $year; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <?php for ($year = 1; $year <= 4; $year++): ?>
                            <div class="tab-pane fade <?php echo ($year == 1) ? 'show active' : ''; ?>" id="pills-year<?php echo $year; ?>" role="tabpanel" aria-labelledby="pills-year<?php echo $year; ?>-tab">
                                <?php if (isset($encoded_grades_by_year[$year]) && count($encoded_grades_by_year[$year]) > 0): ?>
                                    <table class="table table-striped encoded-encoded_grades-table">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Grade</th>
                                                <th>Semester</th>
                                                <th>Units</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($encoded_grades_by_year[$year] as $grade): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($grade['subject_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['semester']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['unit']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No encode grades available for this year.</p>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <p>Student not found.</p>
                <?php endif; ?>

        
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.encoded-encoded_grades-table').DataTable();
    });
</script>
</body>
</html>
