<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require_once "../../config/database_config.php";

$email = $_POST['email'] ?? '';

if (empty($email)) {
    echo json_encode([
        "success" => false,
        "message" => "Email is required"
    ]);
    exit;
}

$sql = "INSERT INTO email (email) VALUES (:email)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Email received",
        "email" => $email
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error occurred while saving email"
    ]);
}

?>