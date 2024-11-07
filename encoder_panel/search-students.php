<?php
// Database connection
include ("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = mysqli_real_escape_string($conn, $_POST['query']);

    // Fetch students based on the search query (name)
    $sql = "SELECT * FROM students WHERE first_name LIKE '%$query%' OR last_name LIKE '%$query%' LIMIT 10";
    $result = mysqli_query($conn, $sql);

    $students = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
    }

    // Return results as JSON
    echo json_encode($students);
}

mysqli_close($conn);
?>
