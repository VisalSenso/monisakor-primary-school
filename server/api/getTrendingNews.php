<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once "../config/db.php";

// Get language parameter (default: Khmer)
$lang = $_GET['lang'] ?? 'kh';

if (!isset($connection)) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

try {
    $query = "SELECT id, about, about_en, date, time, image_url, total_views, total_downloads, likes 
              FROM school_notice 
              WHERE deleted_at IS NULL 
              ORDER BY total_views DESC, likes DESC, total_downloads DESC 
              LIMIT 5";

    $stmt = $connection->prepare($query);
    if (!$stmt) {
        throw new Exception("SQL Prepare Error: " . $connection->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $trendingNews = [];
    while ($row = $result->fetch_assoc()) {
        // Replace fields with English versions if requested
        if ($lang === 'en') {
            if (!empty($row['about_en'])) {
                $row['about'] = $row['about_en'];
            }
        }

        // Remove translation-specific fields
        unset($row['about_en']);

        $trendingNews[] = $row;
    }

    echo json_encode(["trendingNews" => $trendingNews]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $stmt?->close();
    $connection?->close();
}
