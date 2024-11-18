<?php
// Include database connection
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate inputs
    if (empty($email) || empty($user_id) || empty($role)) {
        echo json_encode([
            'success' => false,
            'message' => 'Email, Student ID, and Role are required.'
        ]);
        exit;
    }

    // Check if role is valid
    if (!in_array($role, ['Student', 'Staff'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid role selected.'
        ]);
        exit;
    }

    // Insert query to add the password reset request
    $query = "INSERT INTO password_reset_requests (email, user_id, role, request_time, status) 
              VALUES (?, ?, ?, NOW(), 'pending')";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters and execute query
        mysqli_stmt_bind_param($stmt, 'sss', $email, $user_id, $role);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                'success' => true,
                'message' => 'Password reset request submitted successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to submit password reset request.'
            ]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error. Please try again later.'
        ]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
