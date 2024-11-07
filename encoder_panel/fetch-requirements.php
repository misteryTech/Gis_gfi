<?php
include ("connection.php");

// Fetch all requirements
$sql = "SELECT * FROM requirements";
$result = mysqli_query($conn, $sql);

// Check for SQL errors
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Sanitize output
        $id = htmlspecialchars($row['id']);
        $title = htmlspecialchars($row['title']);
        $description = htmlspecialchars($row['description']);
        $steps = htmlspecialchars($row['steps']);

        echo "<tr>
            <td>{$id}</td>
            <td>{$title}</td>
            <td>{$description}</td>
            <td>{$steps}</td>
            <td>
                <button class='btn btn-warning edit-btn'
                    data-id='{$id}'
                    data-title='{$title}'
                    data-description='{$description}'
                    data-steps='{$steps}'>Edit</button>
                <button class='btn btn-danger delete-btn' data-id='{$id}'>Delete</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No requirements found</td></tr>";
}

// Close connection
mysqli_close($conn);
?>
