<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "gis_database");

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the ID is provided
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $subject_id = $_POST['id'];

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the subject details and return as JSON
                $subject = $result->fetch_assoc();
                echo json_encode($subject);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Subject not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch subject details']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid subject ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
