<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "../config/db.php"; // Include database connection

try {
    // Fetch the content for id = 4
    $query = "SELECT * FROM web_content WHERE id = 4";
    $result = mysqli_query($connection, $query);
    $web_content = [];

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            // If data is found, populate the $web_content array
            $web_content = $row;
        } else {
            // If no data is found, set an error message
            echo json_encode(["error" => "No content found with id = 4"]);
            exit;
        }
    } else {
        echo json_encode(["error" => "Error executing the query: " . mysqli_error($connection)]);
        exit;
    }

    // Return the web content in the response
    $response = [
        'web_content' => $web_content,
    ];
    echo json_encode($response);

    // Handle form submission for feedback
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure connection is established
        $mysqli = $connection;  // Using the established connection
        
        if ($mysqli->connect_error) {
            echo json_encode(["error" => "Connection failed: " . $mysqli->connect_error]);
            exit;
        }

        // Sanitize and validate inputs
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $message = trim($_POST['message']);

        if (empty($name) || empty($email) || empty($message)) {
            echo json_encode(["error" => "Please fill in all required fields."]);
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["error" => "Invalid email format."]);
            exit;
        }

        // Prepare and execute the insert query
        date_default_timezone_set('Asia/Phnom_Penh');
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        $sql = "INSERT INTO contactfeedback (date, time, name, email, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: " . $mysqli->error]);
            exit;
        }

        $stmt->bind_param("sssss", $currentDate, $currentTime, $name, $email, $message);

        if ($stmt->execute()) {
            // Update notification count in the database
            mysqli_query($mysqli, "UPDATE `notification` SET total_notification = total_notification + 1 WHERE id = 2");
            
            // Return success response
            echo json_encode([
                "success" => "Your submission has been successfully sent to the administration."
            ]);
        } else {
            echo json_encode(["error" => "Error executing statement: " . $stmt->error]);
        }

        $stmt->close();
        $mysqli->close();
    }
} catch (Exception $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
} finally {
    mysqli_close($connection);
}
?>
