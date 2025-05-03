<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "../config/db.php";

$album = $_GET["album"] ?? "";
$lang = $_GET['lang'] ?? 'en';

if (!$album) {
    echo json_encode(["error" => "Album not provided"]);
    exit;
}

// Match based on the language
if ($lang === 'en') {
    $fetch_images = "SELECT id, album, album_en, image_url FROM gallery_images WHERE album_en = ?";
} else {
    $fetch_images = "SELECT id, album, album_en, image_url FROM gallery_images WHERE album = ?";
}

$stmt = $connection->prepare($fetch_images);
$stmt->bind_param("s", $album);
$stmt->execute();
$result = $stmt->get_result();

$imageData = [];
while ($row = $result->fetch_assoc()) {
    $album_name = $lang === 'en' && $row['album_en'] ? $row['album_en'] : $row['album'];
    $imageData[] = [
        "album_name" => $album_name,
        "image_url" => $row["image_url"]
    ];
}

echo json_encode($imageData);
?>
