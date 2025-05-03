<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "../config/db.php"; // Include database connection

try {
    // Handle POST request for inserting data first
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Debugging log
        error_log('POST request received');
        
        // Capture POST data
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        
        error_log("Received Data: Name = $name, Phone = $phone, Message = $message");
    
        if (empty($name) || empty($phone) || empty($message)) {
            echo json_encode(["error" => "Please fill in all required fields."]);
            exit;
        }
    
        // Validate phone format
        if (!preg_match("/^[0-9]{9,15}$/", $phone)) {
            echo json_encode(["error" => "Invalid phone format."]);
            exit;
        }
    
        // Connect to database
        $mysqli = $connection;
        if ($mysqli->connect_error) {
            echo json_encode(["error" => "Connection failed: " . $mysqli->connect_error]);
            exit;
        }
    
        // Prepare and execute the insert query
        date_default_timezone_set('Asia/Phnom_Penh');
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
    
        $sql = "INSERT INTO contactfeedback (date, time, name, phone, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
    
        if ($stmt === false) {
            error_log("Prepare failed: " . $mysqli->error);
            echo json_encode(["error" => "Prepare failed: " . $mysqli->error]);
            exit;
        }
    
        $stmt->bind_param("sssss", $currentDate, $currentTime, $name, $phone, $message);
    
        if ($stmt->execute()) {
            $updateQuery = "UPDATE `notification` SET total_notification = total_notification + 1 WHERE id = 2";
            if (mysqli_query($mysqli, $updateQuery)) {
                echo json_encode([ "success" => "Your submission has been successfully sent to the administration." ]);
            } else {
                error_log("Error updating notification count: " . mysqli_error($mysqli));
                echo json_encode(["error" => "Error updating notification count: " . mysqli_error($mysqli)]);
            }
        } else {
            error_log("Error executing statement: " . $stmt->error);
            echo json_encode(["error" => "Error executing statement: " . $stmt->error]);
        }
    
        $stmt->close();
        exit;  // Exit after POST request processing is complete
    }

    // Fetch the content based on language parameter
    $lang = $_GET['lang'] ?? 'km'; // Default to Khmer

    // Build the list of fields based on language
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

    $sql = "SELECT " . implode(", ", $selectFields) . " FROM web_content WHERE id = 4";
    $result = $connection->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode([ "web_content" => $row ]);
    } else {
        echo json_encode(["error" => "No content found for the specified language."]);
    }

} catch (Exception $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
} finally {
    mysqli_close($connection);
}
?>
