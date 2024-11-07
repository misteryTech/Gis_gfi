<?php

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    // Database connection settings
    $dsn = 'mysql:host=localhost;dbname=gis_database';
    $username = 'root';
    $password = '';

    // Create a PDO instance
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get and sanitize form data
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Basic validation
        if (empty($email) || empty($password)) {
            $response['message'] = 'All fields are required.';
            echo json_encode($response);
            exit;
        }

        // Login check function
        function checkLogin($conn, $email, $password, $table) {
            $stmt = $conn->prepare("SELECT id, email, password, course FROM $table WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        }

        // Check in 'users' table
        if ($user = checkLogin($conn, $email, $password, 'users')) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_course'] = $user['course'];
            $response = ['success' => true, 'message' => 'Login successful.'];
            echo json_encode($response);
            exit;
        }

        // Check in 'encoder' table
        if ($encoder = checkLogin($conn, $email, $password, 'encoder')) {
            session_start();
            $_SESSION['id'] = $encoder['id'];
            $_SESSION['encoder_email'] = $encoder['email'];
            $_SESSION['encoder_course'] = $encoder['course'];
            $response = [
                'success' => true,
                'message' => 'Login successful as encoder.',
                'redirect' => 'encoder_panel/'
            ];
            echo json_encode($response);
            exit;
        }

        // If no match in either table
        $response['message'] = 'Invalid email or password.';
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);

?>
