<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    file_put_contents("error_log.txt", "Error: [$errno] $errstr in $errfile on line $errline\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error. Check error_log.txt"]);
    exit;
});

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS, POST");
header("Access-Control-Allow-Headers: *");

require_once "../config/db.php";

$inputData = $_POST;

$requiredFields = [
    "full_name",
    "gender",
    "dob",
    "father_name",
    "father_job",
    "mother_name",
    "mother_job",
    "place_of_birth",
    "current_place",
    "phone"
];

foreach ($requiredFields as $field) {
    if (!isset($inputData[$field]) || empty($inputData[$field])) {
        echo json_encode(["error" => "Missing or empty field: $field"]);
        exit;
    }
}

$full_name = $inputData['full_name'];
$gender = $inputData['gender'];
$dob = $inputData['dob'];
$father_name = $inputData['father_name'];
$father_job = $inputData['father_job'];
$mother_name = $inputData['mother_name'];
$mother_job = $inputData['mother_job'];
$place_of_birth = $inputData['place_of_birth'];
$current_place = $inputData['current_place'];
$phone = $inputData['phone'];

$image_url = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (in_array($_FILES['image']['type'], $allowedTypes)) {
        $fileUploadName = $_FILES['image']['name'];
        $fileUploadTmp = $_FILES['image']['tmp_name'];
        $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/project/monisakor-primary-school/assets/images/joinus/';
        $targetFilePath = $targetDirectory . basename($fileUploadName);

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (!is_writable($targetDirectory)) {
            echo json_encode(["error" => "Target directory is not writable"]);
            exit;
        }

        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $image_url = '/project/monisakor-primary-school/assets/images/joinus/' . basename($fileUploadName);
        } else {
            echo json_encode(["error" => "Failed to upload image"]);
            exit;
        }
    } else {
        echo json_encode(["error" => "Invalid image type"]);
        exit;
    }
} else {
    echo json_encode(["error" => "No image uploaded or upload error"]);
    exit;
}

$sql = "INSERT INTO students_register (full_name, gender, dob, father_name, father_job, mother_name, mother_job, place_of_birth, current_place, phone, image_url) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connection->prepare($sql);
if (!$stmt) {
    error_log("SQL Error: " . $connection->error);
    echo json_encode(["error" => "SQL Error occurred"]);
    exit;
}

$stmt->bind_param("sssssssssss", $full_name, $gender, $dob, $father_name, $father_job, $mother_name, $mother_job, $place_of_birth, $current_place, $phone, $image_url);

if ($stmt->execute()) {
    $updateQuery = "UPDATE `notification` SET total_notification = total_notification + 1 WHERE id = 1";
    if (mysqli_query($connection, $updateQuery)) {
        echo json_encode(["message" => "Student registered successfully!"]);
    } else {
        error_log("Notification Update Error: " . mysqli_error($connection));
        echo json_encode(["error" => "Notification update failed"]);
    }
} else {
    error_log("Execute Error: " . $stmt->error);
    echo json_encode(["error" => "Insert failed"]);
}

$stmt->close();
$connection->close();
exit;
