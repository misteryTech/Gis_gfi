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

        // Function to check login for a table
        function checkLogin($conn, $email, $password, $table) {
            $stmt = $conn->prepare("SELECT id, email, password FROM $table WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        }

        // Check if user exists in 'users' table
        $user = checkLogin($conn, $email, $password, 'users');
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $response['success'] = true;
            $response['message'] = 'Login successful.';
            echo json_encode($response);
            exit;
        }

        // Check if user exists in 'encoder' table
        $encoder = checkLogin($conn, $email, $password, 'encoder');
        if ($encoder) {
            session_start();
            $_SESSION['encoder_id'] = $encoder['id'];
            $_SESSION['encoder_course'] = $encoder['course'];
            $_SESSION['encoder_email'] = $encoder['email'];
            $response['success'] = true;
            $response['message'] = 'Login successful as encoder.';
            $response['redirect'] = 'encoder_panel/'; // Redirect to encoder panel
            echo json_encode($response);
            exit;
        }

        // Invalid credentials if neither table has the user
        $response['message'] = 'Invalid email or password.';
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);

?>
