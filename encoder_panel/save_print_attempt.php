<?php
// save_print_attempt.php

// Database connection
include ("connection.php");

// Get data from the AJAX request
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
$date_print = isset($_POST['date_print']) ? $_POST['date_print'] : date('Y-m-d');

// Insert the print attempt into the database
$stmt = $conn->prepare("INSERT INTO print_attempts (student_id, date_print, attempts) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE attempts = attempts + 1");
$stmt->bind_param("is", $student_id, $date_print);
$stmt->execute();
$stmt->close();

mysqli_close($conn);
?>
