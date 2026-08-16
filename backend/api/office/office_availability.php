<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "../../config/database_config.php";

try {

    $sql = "SELECT status FROM office_availability WHERE id = 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $status = $stmt->fetchColumn();

    $statusText = ((int)$status === 1)
        ? "Office is Open"
        : "Office is Closed";

    echo json_encode([
        "success" => true,
        "status" => $statusText
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Failed to get office availability"
    ]);
}