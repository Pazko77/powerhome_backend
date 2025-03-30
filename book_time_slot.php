<?php
require 'db_connect.php';

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appliance_id'], $_POST['time_slot_id'], $_POST['order'], $_POST['booked_at'])) {
    $stmt = $pdo->prepare("INSERT INTO appliance_time_slot (appliance_id, time_slot_id, `order`, booked_at) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['appliance_id'], $_POST['time_slot_id'], $_POST['order'], $_POST['booked_at']]);
    $json = json_encode(["message" => "Créneau réservé"], JSON_PRETTY_PRINT);
} else {
    $json = json_encode(["error" => "Données incomplètes"], JSON_PRETTY_PRINT);
}
header('Content-Length: ' . strlen($json));
echo $json;
?>
