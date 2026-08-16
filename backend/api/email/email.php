<?php
date_default_timezone_set('Asia/Manila');
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
//generating ticket
$sql = "SELECT COUNT(*) FROM email WHERE DATE(timestamp) = CURDATE()";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$count = $stmt->fetchColumn();
$ticketNumber = "SAO-" . str_pad($count + 1, 4, '0', STR_PAD_LEFT);

//getting people ahead and calculating serving time
$sql = "SELECT COUNT(*) FROM email WHERE DATE(timestamp) = CURDATE() AND status IN ('Waiting', 'Serving')";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$peopleAhead = $stmt->fetchColumn();
$waitingMinutes = $peopleAhead * 4;
$appointmentTime = date('Y-m-d H:i:s', strtotime("+$waitingMinutes Minutes"));

//inserting it into database
$sqlInsert = "INSERT INTO email (email, ticket_no, appointment_time) VALUES (:email, :ticket_no, :appointment_time)";
$stmt = $pdo->prepare($sqlInsert);
$stmt-> execute([':email' => $email, ':ticket_no' => $ticketNumber, ":appointment_time" => $appointmentTime]);

//send the response to the frontend via api calling
echo json_encode([
    "success" => true,
    "message" => "Ticket created successfully",
    "ticket_no" => $ticketNumber,
    "email" => $email,
    "appointment_time" => $appointmentTime,
    "people_ahead" => $peopleAhead
]);
?>