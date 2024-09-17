<?php
// Include the database connection
include("connection.php"); // Include the database connection file

// Enable error reporting for debugging (remove or comment out for production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_repeat = $_POST['password_repeat'] ?? '';

        // Basic validation (server-side)
        if (empty($email) || empty($password) || empty($password_repeat)) {
            $response['message'] = 'All fields are required.';
            echo json_encode($response);
            exit;
        }

        if ($password !== $password_repeat) {
            $response['message'] = 'Passwords do not match.';
            echo json_encode($response);
            exit;
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['message'] = 'This email is already registered!';
            echo json_encode($response);
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Registration successful!';
        } else {
            $response['message'] = 'Error: Could not register user.';
        }
    }
} catch (PDOException $e) {
    $response['message'] = 'Connection failed: ' . $e->getMessage();
}

// Ensure no extra output is sent
ob_end_clean();

echo json_encode($response);
?>
