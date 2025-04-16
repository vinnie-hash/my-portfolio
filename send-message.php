<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Debugging: Log received POST data
error_log("Received Data: " . print_r($_POST, true));

if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    echo json_encode(["status" => "error", "message" => "Missing form fields"]);
    exit;
}

// Sanitize inputs
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$message = htmlspecialchars(trim($_POST['message']));

// Database connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Insert into database
$sql = "INSERT INTO vincent (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Query preparation failed: " . $conn->error]);
}

$conn->close();
?>
