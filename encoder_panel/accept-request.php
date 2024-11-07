<?php
// Database connection
include ("connection.php");


// Check if the request contains a valid student ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['id']);
    $acceptRequest = "Grades Ready to View";

    // Update the request status to 'accepted'
    $query = "UPDATE grade_access_requests_db SET status = 'accepted', comment = '$acceptRequest' WHERE student_id = '$student_id'";



    if (mysqli_query($conn, $query)) {
        // Redirect to a success page or back to the list after updating
        header("Location:  request_grade_page.php?status=success");
        exit();
    } else {
        // Handle the error if the query fails
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Redirect to an error page if no student ID is found in the request
    header("Location: manage-list-students.php?status=error");
    exit();
}

// Close the connection
mysqli_close($conn);
?>
