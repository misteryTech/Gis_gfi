<?php
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $reject_reason = $_POST['reject_reason'];

    // Update the request status to 'Rejected' and store the reason
    $query = "UPDATE grade_access_requests_db SET status = 'Pending', comment = ? WHERE student_id = ?";
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
