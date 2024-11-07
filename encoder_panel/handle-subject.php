<?php
include ("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $subject_unit = mysqli_real_escape_string($conn, $_POST['subject_unit']);

    // Check if the subject already exists
    $check_sql = "SELECT * FROM subjects WHERE subject_code='$subject_code'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Subject exists, update
        $update_sql = "UPDATE subjects SET subject_name='$subject_name', year='$year', semester='$semester', unit='$subject_unit' WHERE subject_code='$subject_code'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Subject updated successfully";
        } else {
            echo "Error updating subject: " . mysqli_error($conn);
        }
    } else {
        // Insert new subject
        $insert_sql = "INSERT INTO subjects (subject_code, subject_name, year, semester, unit) VALUES ('$subject_code', '$subject_name', '$year', '$semester', '$subject_unit')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "Subject registered successfully";
        } else {
            echo "Error registering subject: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
