<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the required data is sent via POST
if (isset($_POST['id'], $_POST['subject_code'], $_POST['subject_name'], $_POST['subject_unit'], $_POST['year'], $_POST['semester'])) {
    $id = intval($_POST['id']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $subject_unit = floatval($_POST['subject_unit']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);

    // Prepare and execute the update query
    $sql = "UPDATE subjects SET subject_code = ?, subject_name = ?, unit = ?, year = ?, semester = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdsdi", $subject_code, $subject_name, $subject_unit, $year, $semester, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Subject updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating subject."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["success" => false, "message" => "Invalid data submitted."]);
}

// Close database connection
mysqli_close($conn);
?>
