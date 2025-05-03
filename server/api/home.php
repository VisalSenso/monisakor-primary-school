<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "../config/db.php";

// Get the language parameter
$lang = $_GET['lang'] ?? 'kh'; // Default to Khmer

try {
    $query = "SELECT * FROM web_content WHERE id = 1";
    $flash_query = "SELECT * FROM flash_notice WHERE id = 1 ";
    $result = mysqli_query($connection, $query);
    $flash_result = mysqli_query($connection, $flash_query);

    $web_content = [];
    $flash_notice = [];
    $notices = [];
    
    if ($result) {
        $web_content = mysqli_fetch_assoc($result);
    } else {
        throw new Exception("Error executing the query: " . mysqli_error($connection));
    }

    if ($flash_result) {
        $flash_notice = mysqli_fetch_assoc($flash_result);
    } else {
        throw new Exception("Error executing flash_notice query: " . mysqli_error($connection));
    }

    $fetch_notice_data = "SELECT * FROM `school_notice` WHERE `deleted_at` IS NULL ORDER BY `id` DESC";
    $notices_result = mysqli_query($connection, $fetch_notice_data);
    
    if ($notices_result) {
        while ($row = mysqli_fetch_assoc($notices_result)) {
            // Replace content with English version if lang is 'en' and translation exists
            if ($lang === 'en') {
                if (!empty($row['about_en'])) {
                    $row['about'] = $row['about_en'];
                }
                if (!empty($row['notice_description_en'])) {
                    $row['notice_description'] = $row['notice_description_en'];
                }
            }
            unset($row['about_en'], $row['notice_description_en']); // Optional: remove translation fields from response
            $notices[] = $row;
        }
    } else {
        throw new Exception("Error executing school_notice query: " . mysqli_error($connection));
    }

    $response = [
        'web_content' => $web_content,
        'flash_notice' => $flash_notice,
        'notices' => $notices,
        'totalNotice' => mysqli_num_rows($notices_result)
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    mysqli_close($connection);
}
