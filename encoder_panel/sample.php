<?php
// Include database connection
require 'connection.php';

// Start session to retrieve encoder info
session_start();

// Fetch student_id from the URL or POST request
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 1003;

// Check if student_id is provided
if (!$student_id) {
    echo "No student ID provided!";
    exit;
}

// Prepare SQL query to fetch encoded grades for the student
$query = "SELECT*
          FROM encoded_grades_table eg
          WHERE eg.encoder_id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);  // 'i' for integer (student_id)
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if any grades are found
if ($result->num_rows > 0) {
    // Output the grades in a table
    echo "<h2>Encoded Grades for Student ID: $student_id</h2>";
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>";

    // Loop through the result and display each row
    while ($row = $result->fetch_assoc()) {
        $subject_name = htmlspecialchars($row['subject_name']);
        $grade = $row['grade'];  // Grade as decimal (e.g., 75.50)
        $remarks = htmlspecialchars($row['remarks']);

        // Format the grade to show 2 decimal places (e.g., 75.50)
        // Ensure the grade is a decimal with 2 places
        $formatted_grade = number_format($grade, 2, '.', '');  // Ensures decimal format with 2 digits

        // Display each row of data
        echo "<tr>
                <td>$subject_name</td>
                <td>$formatted_grade</td>
                <td>$remarks</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>No grades found for student ID: $student_id</p>";
}

// Close the statement
$stmt->close();
?>
