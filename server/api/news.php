<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../config/db.php"; // Include database connection

$sql = "SELECT * FROM `school_notice` WHERE `deleted_at` IS NULL ORDER BY `id` DESC";
$result = $conn->query($sql);

$notices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
}

echo json_encode($notices, JSON_PRETTY_PRINT);
?>

