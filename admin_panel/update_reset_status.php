<?php
include("connection.php"); // Include the database connection file

if (isset($_POST['reset_request_id']) && isset($_POST['status'])) {
    // Get the ID and the new status from the AJAX request
    $id = $_POST['reset_request_id'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the status of the request
    $sql = "UPDATE password_reset_requests SET status = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind the parameters and execute the query
        mysqli_stmt_bind_param($stmt, "si", $status, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Return success message if the update was successful
     

            echo "<script>
            alert('Status updated successfully!');
            window.location.href = 'request_password.php'; // Replace 'manage-subject.php' with the actual page you want to redirect to
          </script>";


        } else {
            echo "Error updating status. Please try again.";
        }
    } else {
        echo "Error preparing the query.";
    }

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
