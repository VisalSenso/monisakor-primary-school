<?php
// Database connection
include '../connection/database.php';

$gender = $_POST['gender'] ?? '';
$search = $_POST['search'] ?? '';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=students_export.csv');

$output = fopen('php://output', 'w');
echo "\xEF\xBB\xBF"; // UTF-8 BOM for Excel Khmer support
fputcsv($output, ['ឈ្មោះសិស្ស', 'ចុះឈ្មោះនៅ', 'ភេទ', 'ថ្ងៃខែឆ្នាំកំណើត', 'ទីកន្លែងកំណើត']);

// Build query
$sql = "SELECT * FROM students_register WHERE 1";

if (!empty($gender)) {
    $genderSafe = mysqli_real_escape_string($connection, $gender);
    $sql .= " AND gender = '$genderSafe'";
}

if (!empty($search)) {
    $searchSafe = mysqli_real_escape_string($connection, $search);
    $sql .= " AND (full_name LIKE '%$searchSafe%' OR gender LIKE '%$searchSafe%' OR dob LIKE '%$searchSafe%' OR place_of_birth LIKE '%$searchSafe%')";
}

$result = mysqli_query($connection, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['full_name'],
        $row['created_at'],
        $row['gender'],
        $row['dob'],
        $row['place_of_birth']
    ]);
}

fclose($output);
exit;
?>
