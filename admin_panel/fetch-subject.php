<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['subject_code']}</td>
            <td>{$row['subject_name']}</td>
            <td>{$row['year']}</td>
            <td>{$row['semester']}</td>
            <td>
                <button class='btn btn-warning edit-btn' data-id='{$row['id']}'>Edit</button>
                <button class='btn btn-danger delete-btn' data-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No subjects found</td></tr>";
}

mysqli_close($conn);
?>
