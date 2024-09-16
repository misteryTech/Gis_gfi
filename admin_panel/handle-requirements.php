<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['requirements_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);

    // Check if an ID is set for update
    if (isset($_POST['id'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        // Update existing requirement
        $update_sql = "UPDATE requirements SET title='$title', description='$description', steps='$steps' WHERE id='$id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Requirement updated successfully";
        } else {
            echo "Error updating requirement: " . mysqli_error($conn);
        }
    } else {
        // Insert new requirement
        $insert_sql = "INSERT INTO requirements (title, description, steps) VALUES ('$title', '$description', '$steps')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "Requirement registered successfully";
        } else {
            echo "Error registering requirement: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
