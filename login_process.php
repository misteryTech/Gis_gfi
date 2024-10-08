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
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Basic validation (server-side)
        if (empty($email) || empty($password)) {
            $response['message'] = 'All fields are required.';
            echo json_encode($response);
            exit;
        }

        // Fetch user record from the database
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct
            session_start();
            $_SESSION['user_id'] = $user['id']; // Set session variable
            $_SESSION['user_email'] = $user['email'];
            $response['success'] = true;
            $response['message'] = 'Login successful.';
        } else {
            // Invalid credentials
            $response['message'] = 'Invalid email or password.';
        }
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>
