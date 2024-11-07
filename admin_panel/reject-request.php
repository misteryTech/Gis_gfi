<?php
include ("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $reject_reason = $_POST['reject_reason'];

    // Update the request status to 'Rejected' and store the reason
    $query = "UPDATE grade_access_requests_db SET status = 'Rejected', comment = ? WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $reject_reason, $request_id);

    if ($stmt->execute()) {
        // Redirect back to the request list page
        header("Location: request_grade_page.php?message=rejected");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
