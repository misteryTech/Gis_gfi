<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $encoder_id = mysqli_real_escape_string($conn, $_POST['encoder_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // If the password is provided, hash it before updating
    $password = '';
    if (!empty($_POST['password'])) {
        $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    }

    // Check if there's a new password to update
    $new_password = '';
    if (!empty($_POST['change_password'])) {
        $new_password = password_hash(mysqli_real_escape_string($conn, $_POST['change_password']), PASSWORD_DEFAULT);
    }

    // Update query for encoder
    $update_query = "UPDATE encoder SET 
                         first_name = '$firstname',
                        last_name = '$lastname',
                         gender = '$gender',
                         phone = '$phone',
                         email = '$email',
                         course = '$course',
                         username = '$username'";

    // Only update the password if it's provided
    if (!empty($password)) {
        $update_query .= ", password = '$password'";
    }

    // Update the password change if provided
    if (!empty($new_password)) {
        $update_query .= ", password = '$new_password'";
    }

    $update_query .= " WHERE id = '$encoder_id'";

    // Execute the query
    if (mysqli_query($conn, $update_query)) {
        // Success
        echo json_encode(["success" => "Encoder details updated successfully."]);
    } else {
        // Error
        echo json_encode(["error" => "Error updating encoder: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
