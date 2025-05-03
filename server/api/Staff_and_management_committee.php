<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once "../config/db.php"; // Include DB connection

try {
    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        throw new Exception("Database connection failed");
    }

    $lang = $_GET['lang'] ?? 'km'; // Default language is Khmer

    // Build dynamic fields based on the selected language
    $staffFields = ($lang === 'en') 
        ? "name_en AS name, post_en AS role, contact, image_src AS imageUrl"
        : "name, post AS role, contact, image_src AS imageUrl";

    $committeeFields = ($lang === 'en') 
        ? "name_en AS name, position_en AS role, contact_no AS contact, image_src AS imageUrl"
        : "name, position AS role, contact_no AS contact, image_src AS imageUrl";

    // Fetch Staff
    $staff_sql = "SELECT $staffFields FROM staffs WHERE deleted_at IS NULL";
    $staff_result = $connection->query($staff_sql);

    $staff = [];
    if ($staff_result && $staff_result->num_rows > 0) {
        while ($row = $staff_result->fetch_assoc()) {
            $staff[] = $row;
        }
    }

    // Fetch Management Committee
    $committee_sql = "SELECT $committeeFields FROM management_committee WHERE deleted_at IS NULL";
    $committee_result = $connection->query($committee_sql);

    $committee = [];
    if ($committee_result && $committee_result->num_rows > 0) {
        while ($row = $committee_result->fetch_assoc()) {
            $committee[] = $row;
        }
    }

    // Return JSON response
    echo json_encode([
        "staff" => $staff,
        "management_committee" => $committee
    ]);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $connection->close();
}
?>
