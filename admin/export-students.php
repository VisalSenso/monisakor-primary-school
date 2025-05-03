<?php
// Include DB connection
include '../connection/database.php'; // Ensure this defines $connectionobj

// Get student ID from URL and sanitize input
$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Debug: Check if the student ID is being passed
if ($student_id == 0) {
    echo "No student ID passed. URL is: " . $_SERVER['REQUEST_URI'];  // Print the current URL
    exit;
}

// Query to fetch the specific student's data
$sql = "SELECT * FROM students_register WHERE id = $student_id";
$result = $connectionobj->query($sql);

// Check if the student record exists
if ($result->num_rows > 0) {
    // Set headers to download the file as Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="student_' . $student_id . '.xls"');
    header('Cache-Control: max-age=0');

    // Start outputting the Excel content (HTML table)
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
        <th>លេខសម្គាល់</th>
        <th>ឈ្មោះពេញ</th>
        <th>ភេទ</th>
        <th>ថ្ងៃខែឆ្នាំកំណើត</th>
        <th>ឈ្មោះឪពុក</th>
        <th>មុខរបររបស់ឪពុក</th>
        <th>ឈ្មោះម្តាយ</th>
        <th>មុខរបររបស់ម្តាយ</th>
        <th>ទីកន្លែងកំណើត</th>
        <th>ទីកន្លែងបច្ចុប្បន្ន</th>
        <th>លេខទូរស័ព្ទ</th>
        </tr>";

    // Output data for the selected student
    $row = $result->fetch_assoc();
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['gender']}</td>";
    echo "<td>{$row['dob']}</td>";
    echo "<td>{$row['father_name']}</td>";
    echo "<td>{$row['father_job']}</td>";
    echo "<td>{$row['mother_name']}</td>";
    echo "<td>{$row['mother_job']}</td>";
    echo "<td>{$row['place_of_birth']}</td>";
    echo "<td>{$row['current_place']}</td>";
    echo "<td>{$row['phone']}</td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "No data found for student ID: $student_id";
}

exit();
?>
