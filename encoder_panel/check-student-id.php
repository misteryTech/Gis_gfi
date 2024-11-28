<?php


include("connection.php");
// check-student-id.php
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    
 
    
    // Query to check if student ID exists
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo 'exists';  // Student ID already exists
    } else {
        echo 'not_exists';  // Student ID does not exist
    }

    mysqli_close($conn);
}
?>
