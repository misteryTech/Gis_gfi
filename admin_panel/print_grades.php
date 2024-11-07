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

// Prepare data for tab pills
$grades_by_year = [];
while ($grade = mysqli_fetch_assoc($encoded_grades_result)) {
    $year = $grade['numeric_year'];
    if (!isset($grades_by_year[$year])) {
        $grades_by_year[$year] = [];
    }
    $grades_by_year[$year][] = $grade;
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
        .student-details, .encoded-grades {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            margin-right: 10px;
        }

        .encoded-grades-table th, .encoded-grades-table td {
            text-align: center;
        }

        .print-btn {
            display: block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            display: block;
            margin: 0;
            padding: 10px 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 25px;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            #printSection, #printSection * {
                visibility: visible;
            }
            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .print-btn {
                display: none; /* Hide the button when printing */
            }
            .btn-danger {
                display: none; /* Hide the button when printing */
            }
        }
    </style>
    <script>
        function printAndSave() {
            var studentId = <?php echo $student_id; ?>;
            var datePrint = new Date().toISOString().slice(0, 10); // Format YYYY-MM-DD
            
            // Save print attempt to database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "save_print_attempt.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Print the section after saving
                    window.print();
                }
            };
            xhr.send("student_id=" + studentId + "&date_print=" + datePrint);

            // Prevent the button from performing its default action
            return false;
        }
    </script>
</head>
<body>
<section class="py-5 mt-5">
    <div class="container py-5" id="printSection">
        <div class="student-details">
            <a class="btn-danger" href="student-profile.php?student_id=<?php echo htmlspecialchars($student['id']); ?>">Profile</a>
            <h3>Student Details</h3>
            <?php if ($student): ?>
                <img src="<?php echo htmlspecialchars($student['student_photo']); ?>" alt="Student Image" class="img-fluid rounded">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                <p><strong>Year Level:</strong> <?php echo htmlspecialchars($student['year_level']); ?></p>
                <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
            <?php else: ?>
                <p>Student not found.</p>
            <?php endif; ?>
        </div>

        <div class="encoded-grades">
            <h3>Encoded Grades</h3>
            <?php for ($year = 1; $year <= 4; $year++): ?>
                <?php if (isset($grades_by_year[$year]) && count($grades_by_year[$year]) > 0): ?>
                    <h4>Year <?php echo $year; ?></h4>
                    <table class="table table-striped encoded-grades-table">
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
                            <?php foreach ($grades_by_year[$year] as $grade): ?>
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
                    <p>No grades available for Year <?php echo $year; ?>.</p>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <button class="print-btn" onclick="printAndSave()">Print Student Details</button>
    </div>
</section>
</body>
</html>
