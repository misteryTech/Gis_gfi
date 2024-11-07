<?php
include("header.php");

include ("connection.php");


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

// Check if the student is found; otherwise, set an error message
if (!$student) {
    $error_message = "Student details not found.";
}

// Handle student update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $year_level = $_POST['year_level'];
    $course = $_POST['course'];

    // Update student details
    $update_stmt = $conn->prepare("UPDATE students SET first_name=?, last_name=?, gender=?, phone=?, email=?, year_level=?, course=? WHERE student_id=?");
    $update_stmt->bind_param("sssssisi", $first_name, $last_name, $gender, $phone, $email, $year_level, $course, $student_id);
    
    if ($update_stmt->execute()) {
        $success_message = "Student details updated successfully.";
        // Refresh student details after update
        $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();
    } else {
        $error_message = "Failed to update student details.";
    }
}

// Fetch encoded grades
$encoded_grades_result = $conn->prepare("SELECT * FROM encoded_grades_table WHERE student_id = ? AND remarks='passed' ");
$encoded_grades_result->bind_param("i", $id);
$encoded_grades_result->execute();
$grades_result = $encoded_grades_result->get_result();

// Check if any grades are found
$grades_exist = mysqli_num_rows($grades_result) > 0;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
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
                <h3 class="mb-4">Student Profile</h3>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-warning text-center"><?php echo $error_message; ?></div>
                <?php elseif (isset($success_message)): ?>
                    <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
                <?php else: ?>
                    <div class="student-details mb-4">
                        <div class="row align-items-center">
                            <!-- Student Photo -->
                            <div class="col-md-3">
                                <img src="../admin_panel/<?php echo htmlspecialchars($student['student_photo']); ?>" alt="Student Image" class="img-fluid rounded">
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
                            <div class="col-md-2 text-end">
                                <!-- Edit Button -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal">Edit</button>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4">Grades</h4>
                    <?php if (!$grades_exist): ?>
                        <div class="alert alert-danger text-center">No grades encoded.</div>
                    <?php else: ?>
                        <!-- Display grades by year -->
                        <div class="alert alert-info text-center">Grades Uploaded.</div>
                    <?php endif; ?>

                    <!-- Edit Student Modal -->
                    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="year_level" class="form-label">Year Level</label>
                                            <input type="text" class="form-control" id="year_level" name="year_level" value="<?php echo htmlspecialchars($student['year_level']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="course" class="form-label">Course</label>
                                            <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>
                                        </div>
                                        <button type="submit" name="update_student" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.encoded-grades-table').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true
    });
});
</script>
</body>
</html>
