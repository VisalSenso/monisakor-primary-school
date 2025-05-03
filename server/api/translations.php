<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Connect to your database
require_once "../config/db.php"; // Include database connection
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get language parameter
$lang = $_GET['lang'] ?? 'km'; // Default to Khmer

// Build the list of fields
$fields = [
    'content_about', 'one', 'two', 'three', 'four', 'five',
    'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve',
    'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
    'eighteen', 'ninteen', 'twenty', 'twentyone'
];

// Build SELECT clause dynamically
$selectFields = [];
foreach ($fields as $field) {
    if ($lang === 'en') {
        $selectFields[] = "$field" . "_en AS $field";
    } else {
        $selectFields[] = "$field";
    }
}

$sql = "SELECT " . implode(", ", $selectFields) . " FROM web_content WHERE id = 1";
$result = $connection->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No content found"]);
}

$connection->close();
?>
