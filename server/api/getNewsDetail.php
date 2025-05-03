<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once "../config/db.php";

// Get the ID and language (optional, default to Khmer)
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
$lang = $_GET['lang'] ?? 'kh';

if (!$id) {
    echo json_encode(["error" => "Invalid or missing ID"]);
    exit;
}

try {
    $query = "SELECT logo, posted_by, image_url, about, about_en, notice_description, notice_description_en, date, time, total_views, total_downloads, last_modified, likes, views 
              FROM school_notice 
              WHERE id = ? AND deleted_at IS NULL";

    $stmt = $connection->prepare($query);
    if (!$stmt) {
        throw new Exception("SQL Prepare Error: " . $connection->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => "Notice not found"]);
        exit;
    }

    $notice = $result->fetch_assoc();

    // Replace with English version if requested
    if ($lang === 'en') {
        if (!empty($notice['about_en'])) {
            $notice['about'] = $notice['about_en'];
        }
        if (!empty($notice['notice_description_en'])) {
            $notice['notice_description'] = $notice['notice_description_en'];
        }
    }

    // Optionally remove translation fields
    unset($notice['about_en'], $notice['notice_description_en']);

    echo json_encode($notice);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $stmt?->close();
    $connection?->close();
}
?> 