<?php
include("header.php");

include ("connection.php");

// Get the student ID from the query parameter
// Get the student ID from the session
$student_id = $_SESSION['student_id'] ? intval($_SESSION['student_id']) : 0;
$id = $_SESSION['id']  ? intval($_SESSION['id']) : 0;

// Fetch student details
$student = null;
if ($student_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Fetch encoded grades with textual year converted to numeric values
$encoded_grades_result = mysqli_query($conn, "
    SELECT subjects.subject_name, grades.grade, grades.status, subjects.subject_code, subjects.year, subjects.semester AS semester, subjects.unit,
           CASE
               WHEN subjects.year = 'first-year' THEN 1
               WHEN subjects.year = 'second-year' THEN 2
               WHEN subjects.year = 'third-year' THEN 3
               WHEN subjects.year = 'fourth-year' THEN 4
               ELSE 0
           END AS numeric_year
    FROM grades
    JOIN subjects ON grades.subject_id = subjects.id
    WHERE grades.student_id = $id
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
<?php include("navbar.php"); ?>


<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Encoded Grades</h3>

                <?php if ($student): ?>
                


                    <!-- Encoded Grades Section -->
              
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
                                    <p>Request Subject for Year: <?php echo $year; ?>.</p>
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
                info: true,
                print: true
            });
        }
    });
</script>
</body>
</html>
