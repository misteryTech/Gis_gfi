<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if `id` is passed in the query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM subjects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch data and return as JSON
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Subject not found."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Invalid request."]);
}

// Close database connection
mysqli_close($conn);
?>
