<?php
require 'db_connect.php';

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['reference'], $_POST['wattage'], $_POST['habitat_id'])) {
    $stmt = $pdo->prepare("INSERT INTO appliance (name, reference, wattage, habitat_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['reference'], $_POST['wattage'], $_POST['habitat_id']]);
    $json = json_encode(["message" => "Appareil ajouté"]);
} else {
    $json = json_encode(["error" => "Données incomplètes"]);
    header('Content-Length: ' . strlen($json));
    echo $json;
}
?>