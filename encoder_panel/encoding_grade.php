<?php
include("header.php");

include ("connection.php");

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

// Fetch subjects based on the student's course
$subjects_result = null;
if ($student) {
    $course = $student['course'];
    $stmt = $conn->prepare("SELECT id, subject_code, subject_name, unit, curriculum FROM subjects WHERE course = ?");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $subjects_result = $stmt->get_result();
    $stmt->close();
}

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
        .curriculum-table th {
            background-color: #f8f9fa;
            color: #333;
        }
        .curriculum-table td, .curriculum-table th {
            padding: 12px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
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
               
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                        <li><a class="dropdown-item" href="request_grade_page.php">Request Grade</a></li>
                    </ul>
                </li>

                <li class="nav-item active"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>




<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Encode Grades for Student</h3>

                <?php if ($student): ?>
                    <form class="p-3 p-xl-4" action="save-grades.php" method="post">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">

<div class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control shadow" id="name" value="<?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>" disabled>
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label">Student Status</label>
        <input type="text" class="form-control shadow" id="name" value="<?php echo htmlspecialchars($student['student_status']); ?>" disabled>
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


                        <!-- Tabs for New and Old Curriculum -->
                        <ul class="nav nav-pills mb-3" id="curriculumTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="new-curriculum-tab" data-bs-toggle="pill" data-bs-target="#new-curriculum" type="button" role="tab" aria-controls="new-curriculum" aria-selected="true">New Curriculum</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="old-curriculum-tab" data-bs-toggle="pill" data-bs-target="#old-curriculum" type="button" role="tab" aria-controls="old-curriculum" aria-selected="false">Old Curriculum</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="curriculumTabContent">
                            <!-- New Curriculum Table -->
                            <div class="tab-pane fade show active" id="new-curriculum" role="tabpanel" aria-labelledby="new-curriculum-tab">
                                <h5 class="mt-4">New Curriculum Subjects</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered curriculum-table">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Units</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            mysqli_data_seek($subjects_result, 0);
                                            $newCurriculumFound = false;
                                            while ($subject = mysqli_fetch_assoc($subjects_result)):
                                                if ($subject['curriculum'] === 'New'):
                                                    $newCurriculumFound = true;
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                                                    <td>
                                                        <input type="hidden" name="subject_ids[]" value="<?php echo htmlspecialchars($subject['id']); ?>">
                                                        <input type="number" class="form-control" name="grades[]" min="0" max="100" step="0.01" required>
                                                    </td>
                                                    <td>
                                                        <select name="remarks[]" class="form-control">
                                                            <option value="" disabled selected>Remarks:</option>
                                                            <option value="passed">Passed</option>
                                                            <option value="failed">Failed</option>
                                                            <option value="tbe">To Be Encode</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php endwhile; ?>
                                            <?php if (!$newCurriculumFound): ?>
                                                <tr><td colspan="5" class="text-center">No subjects found under New Curriculum</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Old Curriculum Table -->
                            <div class="tab-pane fade" id="old-curriculum" role="tabpanel" aria-labelledby="old-curriculum-tab">
                                <h5 class="mt-4">Old Curriculum Subjects</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered curriculum-table">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Units</th>
                                                <th>Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            mysqli_data_seek($subjects_result, 0);
                                            $oldCurriculumFound = false;
                                            while ($subject = mysqli_fetch_assoc($subjects_result)):
                                                if ($subject['curriculum'] === 'Old'):
                                                    $oldCurriculumFound = true;
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                                                    <td>
                                                        <input type="hidden" name="subject_ids[]" value="<?php echo htmlspecialchars($subject['id']); ?>">
                                                        <input type="number" class="form-control" name="grades[]" min="0" max="100" step="0.01" required>
                                                    </td>
                                                    <td>
                                                        <select name="remarks[]" class="form-control">
                                                            <option value="" disabled selected>Remarks:</option>
                                                            <option value="passed">Passed</option>
                                                            <option value="failed">Failed</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php endwhile; ?>
                                            <?php if (!$oldCurriculumFound): ?>
                                                <tr><td colspan="5" class="text-center">No subjects found under Old Curriculum</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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


<script>
function updateRemarks(gradeInput) {
    const row = gradeInput.closest('tr');
    const gradeValue = parseInt(gradeInput.value);
    const remarksSelect = row.querySelector('select[name="remarks[]"]');

    if (gradeValue >= 1 && gradeValue <= 3) { // Grades 1, 2, 3 are passes
        remarksSelect.value = 'passed';
        remarksSelect.style.backgroundColor = 'lightgreen';
    } else if (gradeValue === 4) { // Grade 4 is a fail
        remarksSelect.value = 'failed';
        remarksSelect.style.backgroundColor = 'lightcoral';
    } else if (gradeValue === 5) { // Grade 4 is a fail
        remarksSelect.value = 'failed';
        remarksSelect.style.backgroundColor = 'lightcoral';
    }else {
        remarksSelect.value = ''; // Clear remarks if the grade is not in the expected range
        remarksSelect.style.backgroundColor = ''; // Reset color
    }

    updateGradeColor(remarksSelect);
}

function updateGradeColor(remarksSelect) {
    const row = remarksSelect.closest('tr');
    const gradeInput = row.querySelector('input[name="grades[]"]');

    if (remarksSelect.value === 'passed') {
        gradeInput.style.backgroundColor = 'lightgreen';
    } else if (remarksSelect.value === 'failed') {
        gradeInput.style.backgroundColor = 'lightcoral';
    } else {
        gradeInput.style.backgroundColor = ''; // Reset if no selection
    }
}

</script>

