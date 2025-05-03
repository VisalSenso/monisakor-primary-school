<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once "../config/db.php"; // Include DB connection

try {
    $lang = $_GET['lang'] ?? 'km'; // Default to Khmer

    // Define content fields
    $fields = [
        'content_about', 'one', 'two', 'three', 'four', 'five',
        'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve',
        'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
        'eighteen', 'ninteen', 'twenty', 'twentyone'
    ];

    // Build SELECT clause based on language
    $selectFields = [];
    foreach ($fields as $field) {
        $selectFields[] = ($lang === 'en') ? "{$field}_en AS {$field}" : $field;
    }

    $sql = "SELECT " . implode(", ", $selectFields) . " FROM web_content WHERE id = 2";
    $result = $connection->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode(['web_content' => $row]);
    } else {
        echo json_encode(["error" => "No content found"]);
    }

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $connection->close();
}
