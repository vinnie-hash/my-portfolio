<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = ""; // use your MySQL password
$database = "portfolio_form"; // replace with your DB name

// Create DB connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize input
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));

// Prepare SQL statement
$sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $subject, $message);

// Execute and give feedback
if ($stmt->execute()) {
    echo "<script>alert('Message sent successfully!'); window.location.href='your_contact_page.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
