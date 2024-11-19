<?php
include("header.php");

include ("connection.php");



// Get the student ID and semester from the query parameters
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$semester = isset($_GET['semester']) ? intval($_GET['semester']) : 0;

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

// Fetch encoded grades based on the selected semester
$encoded_grades_result = mysqli_query($conn, "
    SELECT subjects.subject_name, encoded_grades_table.grade, subjects.subject_code, subjects.year, subjects.semester AS semester, subjects.unit
    FROM encoded_grades_table
    JOIN subjects ON encoded_grades_table.subject_id = subjects.id
    WHERE encoded_grades_table.student_id = $student_id
      AND subjects.semester = $semester
    ORDER BY subjects.year ASC
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

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">

 <style>

body {
    font-size: 16px; /* Increase the base font size */
    font-family: Arial, sans-serif; /* Clean and readable font */
    line-height: 1.6; /* Improved line spacing */
}


.student-details {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 30px;
}

.student-info h3 {
    font-size: 24px; /* Larger heading size */
    font-weight: bold;
    margin-bottom: 10px;
}

.student-info strong {
    font-weight: bold;
}

.encoded-grades-table th {
    font-size: 18px; /* Larger table header text */
    font-weight: bold;
    background-color: #f5f5f5; /* Subtle background for better readability */
    text-align: center;
    padding: 10px;
}


.encoded-grades-table td {
    font-size: 16px; /* Larger table cell text */
    text-align: center;
    padding: 8px;
    vertical-align: middle;
}


/* Buttons */
.print-btn, .btn-danger {
    font-size: 18px; /* Larger font size for buttons */
    padding: 12px 25px; /* More padding for a bigger clickable area */
    border-radius: 8px; /* Rounded corners for better design */
}

.print-btn:hover {
    background-color: #0056b3;
    font-weight: bold;
}



/* Encoded Grades Section */
.encoded-grades h3 {
    font-size: 22px; /* Larger heading for grades */
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 15px;
}

.encoded-grades h4 {
    font-size: 20px; /* Year-level headings */
    font-weight: bold;
    margin-bottom: 10px;
}


 .print-btn {
            margin: 10px 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        .student-info p {
    font-size: 18px; /* Larger paragraph text */
    margin: 8px 0; /* More spacing between lines */
}



 .print-btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: red;
            color: white;
            font-size: 16px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
        }

.student-photo {
    text-align: center;
    flex-shrink: 0;
}

.student-photo img {
    max-width: 150px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.student-info {
    flex-grow: 1;
}

.student-info p {
    margin: 5px 0;
}

@media print {
    body * {
        visibility: hidden;
    }

    #printSection, #printSection * {
        visibility: visible;
    }

    #printSection {
        position: static;
        left: 0;
        top: 0;
        width: 100%;
    }

    .student-details {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 20px;
    }

    .student-photo img {
        max-width: 120px;
    }

    .student-info {
        font-size: 14px;
    }

    .print-btn, .btn-danger {
        display: none;
    }
}

    </style>
    <script>
        function filterAndPrint(semester) {
            const rows = document.querySelectorAll('#encoded-grades-table tbody tr');
            rows.forEach(row => {
                const semesterCell = row.querySelector('td:nth-child(4)').textContent.trim();
                row.style.display = (semesterCell === semester) ? '' : 'none';
            });
            window.print();
            rows.forEach(row => row.style.display = '');
        }

        function printAndSave() {
            const studentId = <?php echo $student_id; ?>;
            const datePrint = new Date().toISOString().slice(0, 10);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_print_attempt.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    window.print();
                }
            };
            xhr.send("student_id=" + studentId + "&date_print=" + datePrint);

            return false;
        }
    </script>
</head>
<body>
<section class="py-5 mt-5">
<div class="container py-5" id="printSection">
        <!-- Student Details Section -->
        <div class="student-details d-flex">
    <div class="student-photo">
        <?php if ($student): ?>
            <a class="btn-danger mb-3 d-block" href="student-profile.php?student_id=<?php echo htmlspecialchars($student['id']); ?>">Profile</a>
            <img src="<?php echo htmlspecialchars($student['student_photo']); ?>" alt="Student Image" class="img-fluid">
        <?php endif; ?>
    </div>
    <div class="student-info">
        <h3>Student Details</h3>
        <?php if ($student): ?>
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
</div>


        <!-- Encoded Grades Section -->
        <div class="encoded-grades">
            <h3>Encoded Grades - Semester <?php echo $semester; ?></h3>
            <div class="row">
                <?php for ($year = 1; $year <= 4; $year++): ?>
                    <?php if (isset($grades_by_year[$year]) && count($grades_by_year[$year]) > 0): ?>
                        <div class="col-md-6">
                            <h4>Year <?php echo $year; ?></h4>
                            <table class="table table-striped encoded-grades-table">
                                <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Grade</th>
                                        <th>Units</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($grades_by_year[$year] as $grade): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($grade['subject_code']); ?></td>
                                            <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                            <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                                            <td><?php echo htmlspecialchars($grade['unit']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6">
                            <p>No grades available for Year <?php echo $year; ?>.</p>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Print Button -->
        <div class="mt-3">
            <button class="print-btn" onclick="printAndSave()">Print Student Details</button>
        </div>
    </div>
</section>
</body>
</html>