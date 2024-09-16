<?php
// Include the database connection
include("connection.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Basic validation (server-side)
        if (empty($email) || empty($password)) {
            echo "All fields are required.";
            exit;
        }

        // Fetch user record from the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct
            session_start();
            $_SESSION['user_id'] = $user['id']; // Set session variable
            $_SESSION['user_email'] = $user['email'];
            header("Location: admin_panel/dashboard.php"); // Redirect to the dashboard or home page
            exit;
        } else {
            // Invalid credentials
            echo "Invalid email or password.";
            header("Location: login.php"); // Redirect to the dashboard or home page
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
