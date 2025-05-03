<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once "../config/db.php"; // Include database connection

try {
    // Get language parameter, default to 'en'
    $lang = $_GET['lang'] ?? 'en'; 

    // Define the fields to select based on language
    $fields = ['album_name']; // Here you can add more fields if needed like 'album_description'

    // Build the SELECT clause dynamically based on the requested language
    $selectFields = [];
    foreach ($fields as $field) {
        // If language is 'en', use album_name_en, otherwise fallback to default
        $selectFields[] = ($lang === 'en') ? "{$field}_en AS {$field}" : $field;
    }

    // Construct SQL query to fetch the album data
    $sql = "SELECT " . implode(", ", $selectFields) . " FROM `gallery_album`";
    $result = $connection->query($sql);

    // Check if there are results and return them as JSON
    if ($result && $result->num_rows > 0) {
        $albumData = [];
        while ($row = $result->fetch_assoc()) {
            $albumData[] = ["album_name" => $row["album_name"]];
        }
        echo json_encode($albumData);
    } else {
        echo json_encode(["error" => "No albums found"]);
    }

} catch (Exception $e) {
    // Catch any errors and return the error message
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    // Ensure the database connection is closed
    $connection->close();
}
?>
