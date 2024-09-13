<?php
// Database connection
include("connection.php"); // Include the database connection file

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];

        // Basic validation (server-side)
        if (empty($email) || empty($password) || empty($password_repeat)) {
            echo "All fields are required.";
            exit;
        }

        if ($password !== $password_repeat) {
            echo "Passwords do not match.";
            exit;
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "This email is already registered!";
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
            echo "Registration successful!";
            // Redirect to success page or login page
            header("Location: login.php");
            exit;
        } else {
            echo "Error: Could not register user.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
