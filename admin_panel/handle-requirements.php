<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form inputs
    $requirements_title = mysqli_real_escape_string($conn, trim($_POST['requirements_title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $steps = mysqli_real_escape_string($conn, trim($_POST['steps']));

    // Example debug output (remove this in production)
    // echo "Received: " . print_r($_POST, true);

    // Check if all fields are filled
    if (!empty($requirements_title) && !empty($description) && !empty($steps)) {
        // Insert data into the database
        $sql = "INSERT INTO requirements (title, description, steps) VALUES ('$requirements_title', '$description', '$steps')";

        if (mysqli_query($conn, $sql)) {
            // Success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Requirement submitted successfully!'
            ]);
        } else {
            // Error response if query fails
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to submit requirement: ' . mysqli_error($conn)
            ]);
        }
    } else {
        // Error response if fields are missing
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill in all fields.'
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

// Close the database connection
mysqli_close($conn);
?>
