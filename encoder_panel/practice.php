<?php
include("header.php");

include ("connection.php");
// Get the encoder's user ID from the session


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

}

// Fetch subjects based on the student's course
$subjects_result = null;
if ($student) {
    $course = $student['course'];
    $stmt = $conn->prepare("SELECT id, subject_code, subject_name, unit, curriculum FROM subjects WHERE course = ? AND archive='0' ");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $subjects_result = $stmt->get_result();

}


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




                        <?php


// Fetch available curriculums
// Fetch unique curriculums from the subjects table<?php
include("connection.php");

// Fetch unique curriculums from the subjects table 
$curriculums_result = mysqli_query($conn, "SELECT DISTINCT curriculum FROM subjects  WHERE course= '$course'");
$curriculums = [];

while ($row = mysqli_fetch_assoc($curriculums_result)) {
    $curriculums[] = $row['curriculum']; // Store curriculum names
}






// Fetch subjects and group them by curriculum
$subjects_result = mysqli_query($conn, "SELECT * FROM subjects WHERE course= '$course'");
$subjects_by_curriculum = [];

while ($subject = mysqli_fetch_assoc($subjects_result)) {
    $curriculum_name = $subject['curriculum'];
    $subjects_by_curriculum[$curriculum_name][] = $subject;
}
?>

<!-- Curriculum Tabs -->
<ul class="nav nav-pills mb-3" id="curriculumTabs" role="tablist">
    <?php 
    $isFirst = true; // To make the first tab active by default
    foreach ($curriculums as $curriculum_name): 
    ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo $isFirst ? 'active' : ''; ?>" 
                    id="curriculum-tab-<?php echo md5($curriculum_name); ?>" 
                    data-bs-toggle="pill" 
                    data-bs-target="#curriculum-<?php echo md5($curriculum_name); ?>" 
                    type="button" 
                    role="tab" 
                    aria-controls="curriculum-<?php echo md5($curriculum_name); ?>" 
                    aria-selected="<?php echo $isFirst ? 'true' : 'false'; ?>">
                <?php echo htmlspecialchars($curriculum_name); ?>
            </button>
        </li>
    <?php 
    $isFirst = false; // Only first tab should be active
    endforeach; 
    ?>
</ul>

<div class="tab-content" id="curriculumTabContent">
    <?php 
    $isFirst = true;
    foreach ($curriculums as $curriculum_name): 
    ?>
        <div class="tab-pane fade <?php echo $isFirst ? 'show active' : ''; ?>" 
             id="curriculum-<?php echo md5($curriculum_name); ?>" 
             role="tabpanel" 
             aria-labelledby="curriculum-tab-<?php echo md5($curriculum_name); ?>">
             
            <h5 class="mt-4"><?php echo htmlspecialchars($curriculum_name); ?> Subjects</h5>
            
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
                        <?php if (!empty($subjects_by_curriculum[$curriculum_name])): ?>
                            <?php foreach ($subjects_by_curriculum[$curriculum_name] as $subject): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                                    <td>
                                        <input type="hidden" name="subject_ids[]" value="<?php echo htmlspecialchars($subject['id']); ?>">
                                        <input type="number" class="form-control" name="grades[]" min="1.00" max="5.00" step="0.01" required oninput="updateRemarks(this)">
                                    </td>
                                    <td>
                                        <select name="remarks[]" class="form-control">
                                            <option value="" disabled selected>Remarks:</option>
                                            <option value="passed">Passed</option>
                                            <option value="failed">Failed</option>
                                            <option value="tbe">To Be Encoded</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No subjects found under <?php echo htmlspecialchars($curriculum_name); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php 
    $isFirst = false;
    endforeach; 
    ?>
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
    const gradeValue = parseFloat(gradeInput.value); // Parse the grade value as a float for decimals
    const remarksSelect = row.querySelector('select[name="remarks[]"]');

    // Ensure grade value is within the valid range (1.00 to 5.00)
    if (!isNaN(gradeValue) && gradeValue >= 1.00 && gradeValue <= 5.00) {
        if (gradeValue >= 1.00 && gradeValue <= 3.00) { // Grades 1.00 to 3.00 are passed
            remarksSelect.value = 'passed';
            remarksSelect.style.backgroundColor = 'lightgreen';
        } else if (gradeValue > 3.00 && gradeValue <= 5.00) { // Grades 3.1 to 5.00 are failed
            remarksSelect.value = 'failed';
            remarksSelect.style.backgroundColor = 'lightcoral';
        }
    } else if (gradeInput.value === '') {
        // If grade input is empty, reset remarks
        remarksSelect.value = 'tbe';
        remarksSelect.style.backgroundColor = ''; // Reset background color
    } else { // If the grade is outside the valid range, reset remarks
        remarksSelect.value = 'tbe';
        remarksSelect.style.backgroundColor = ''; // Reset background color
    }
}

function updateGradeColor(remarksSelect) {
    const row = remarksSelect.closest('tr');
    const gradeInput = row.querySelector('input[name="grades[]"]');

    if (remarksSelect.value === 'passed') {
        gradeInput.style.backgroundColor = 'lightgreen';
    } else if (remarksSelect.value === 'failed') {
        gradeInput.style.backgroundColor = 'lightcoral';
    } else if (remarksSelect.value === 'tbe') {
        gradeInput.style.backgroundColor = 'lightyellow';
    } else {
        gradeInput.style.backgroundColor = ''; // Reset if no selection
    }
}


</script>

