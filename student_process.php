<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "gis_database";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_no = mysqli_real_escape_string($conn, $_POST['id_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to fetch the user data based on ID number
    $query = "SELECT student_id,id, password FROM students WHERE student_id = '$id_no'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password using password_verify()
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, store student_id in session and return success response
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['id'] = $row['id'];

            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            // Incorrect password
            echo json_encode(['success' => false, 'message' => 'Incorrect ID number or password']);
        }
    } else {
        // No user found with the provided ID number
        echo json_encode(['success' => false, 'message' => 'Incorrect ID number or password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
