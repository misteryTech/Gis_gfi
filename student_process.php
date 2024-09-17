<?php

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

try {
    // Database connection settings
    $dsn = 'mysql:host=localhost;dbname=gis_database'; // Adjust the host, dbname, etc.
    $username = 'root'; // Replace with your database username
    $password = ''; // Replace with your database password

    // Create a PDO instance
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $id_no = isset($_POST['id_no']) ? trim($_POST['id_no']) : ''; // Changed from email to id_no
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Basic validation (server-side)
        if (empty($id_no) || empty($password)) {
            $response['message'] = 'All fields are required.';
            echo json_encode($response);
            exit;
        }

        // Fetch user record from the database
        $stmt = $conn->prepare("SELECT id, student_id, password FROM students WHERE student_id = :id_no");
        $stmt->bindParam(':id_no', $id_no);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct
            session_start();
            $_SESSION['student_id'] = $user['id']; // Set session variable
            $_SESSION['student_id_no'] = $user['id_no'];
            $response['success'] = true;
            $response['message'] = 'Login successful.';
        } else {
            // Invalid credentials
            $response['message'] = 'Invalid ID number or password.';
        }
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>
