<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once "../config/db.php";

// Get language parameter, default to Khmer
$lang = $_GET['lang'] ?? 'kh';

if (!isset($connection)) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

try {
    // Prepare query for recent news (latest 5)
    $query = "SELECT id, logo, posted_by, image_url, about, about_en, notice_description, notice_description_en, date, time 
              FROM school_notice 
              WHERE deleted_at IS NULL 
              ORDER BY id DESC 
              LIMIT 5";

    $stmt = $connection->prepare($query);
    if (!$stmt) {
        throw new Exception("SQL Prepare Error: " . $connection->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $recentNews = [];
    while ($row = $result->fetch_assoc()) {
        // If English language is requested, override fields if available
        if ($lang === 'en') {
            if (!empty($row['about_en'])) {
                $row['about'] = $row['about_en'];
            }
            if (!empty($row['notice_description_en'])) {
                $row['notice_description'] = $row['notice_description_en'];
            }
        }

        // Remove translation-specific fields
        unset($row['about_en'], $row['notice_description_en']);

        $recentNews[] = $row;
    }

    echo json_encode(["recentNews" => $recentNews]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $stmt?->close();
    $connection?->close();
}
?>
