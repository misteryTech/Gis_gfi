<?php
include("header.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get posted data
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
$subject_ids = isset($_POST['subject_ids']) ? $_POST['subject_ids'] : [];
$grades = isset($_POST['grades']) ? $_POST['grades'] : [];

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade) VALUES (?, ?, ?)");

// Bind parameters and execute statement for each subject-grade pair
foreach ($subject_ids as $index => $subject_id) {
    $grade = isset($grades[$index]) ? floatval($grades[$index]) : 0;
    $stmt->bind_param("iid", $student_id, $subject_id, $grade);
    $stmt->execute();
}

$stmt->close();
mysqli_close($conn);
echo "<script>
    alert('Succesfully Encoded Grades');
    window.location.href = 'encode-grades.php?student_id=" . $student_id . "';
</script>";

exit();
?>
