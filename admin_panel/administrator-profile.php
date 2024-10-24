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

// Fetch encoded grades with textual year converted to numeric values
$encoded_grades_result = mysqli_query($conn, "
    SELECT subjects.subject_name, grades.grade, subjects.subject_code, subjects.year, subjects.semester AS semester, subjects.unit,
           CASE
               WHEN subjects.year = 'first-year' THEN 1
               WHEN subjects.year = 'second-year' THEN 2
               WHEN subjects.year = 'third-year' THEN 3
               WHEN subjects.year = 'fourth-year' THEN 4
               ELSE 0
           END AS numeric_year
    FROM grades
    JOIN subjects ON grades.subject_id = subjects.id
    WHERE grades.student_id = $student_id
    ORDER BY semester ASC
");

mysqli_close($conn);

// Prepare data for tab pills
$grades_by_year = [];
while ($grade = mysqli_fetch_assoc($encoded_grades_result)) {
    $year = $grade['numeric_year'];
    if (!isset($grades_by_year[$year])) {
        $grades_by_year[$year] = [];
    }
    $grades_by_year[$year][] = $grade;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode Grades</title>
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
        .encoded-grades-table th, .encoded-grades-table td {
            text-align: center;
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
                <li class="nav-item"><a class="nav-link " href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Student Profile</h3>

                <?php if ($student): ?>
                    <div class="student-details mb-4">
    <div class="row align-items-center">
        <!-- Student Photo -->
        <div class="col-md-3">
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

        <!-- Edit Button -->
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                Edit
            </button>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit-student.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">
                    </div>
                    <div class="mb-3">
    <label for="year_level" class="form-label">Year Level</label>
    <select class="form-select" id="year_level" name="year_level">
        <option value="1st Year" <?php echo ($student['year_level'] == '1st Year') ? 'selected' : ''; ?>>1st Year</option>
        <option value="2nd Year" <?php echo ($student['year_level'] == '2nd Year') ? 'selected' : ''; ?>>2nd Year</option>
        <option value="3rd Year" <?php echo ($student['year_level'] == '3rd Year') ? 'selected' : ''; ?>>3rd Year</option>
        <option value="4th Year" <?php echo ($student['year_level'] == '4th Year') ? 'selected' : ''; ?>>4th Year</option>
    </select>
</div>

<div class="mb-3">
    <label for="course" class="form-label">Course</label>
    <select class="form-select" id="course" name="course">
        <option value="BS Computer Science" <?php echo ($student['course'] == 'BS Computer Science') ? 'selected' : ''; ?>>BS Computer Science</option>
        <option value="BS Information Technology" <?php echo ($student['course'] == 'BS Information Technology') ? 'selected' : ''; ?>>BS Information Technology</option>
        <option value="BS Business Administration" <?php echo ($student['course'] == 'BS Business Administration') ? 'selected' : ''; ?>>BS Business Administration</option>
        <option value="BS Accountancy" <?php echo ($student['course'] == 'BS Accountancy') ? 'selected' : ''; ?>>BS Accountancy</option>
        <option value="BS Psychology" <?php echo ($student['course'] == 'BS Psychology') ? 'selected' : ''; ?>>BS Psychology</option>
        <!-- Add more courses as needed -->
    </select>
</div>

                    <div class="mb-3">
                        <label for="student_photo" class="form-label">Upload New Photo</label>
                        <input type="file" class="form-control" id="student_photo" name="student_photo">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

                    <!-- Encoded Grades Section -->
                    <h4 class="mt-5">Encoded Grades</h4>
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
                                <?php if (isset($grades_by_year[$year]) && count($grades_by_year[$year]) > 0): ?>
                                    <table class="table table-striped encoded-grades-table" id="studentGradesYear<?php echo $year; ?>">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Subject Code</th>
                                                <th>Grade</th>
                                                <th>Units</th>
                                                <th>Semester</th>
                                                <th>Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grades_by_year[$year] as $grade): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['subject_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['unit']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['semester']); ?></td>
                                                    <td><?php echo htmlspecialchars($grade['year']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No grades recorded for Year <?php echo $year; ?>.</p>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                <?php else: ?>
                    <div class="alert alert-warning">Student not found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable for each year's table
        for (let year = 1; year <= 4; year++) {
            $('#studentGradesYear' + year).DataTable({
                paging: true,
                searching: true,
                info: true
            });
        }
    });
</script>
</body>
</html>
