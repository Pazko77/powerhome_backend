<?php
require 'db_connect.php';
$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');
$response = [];

$stmt = $pdo->query("SELECT * FROM time_slot");
$slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($slots) {
    $response['status'] = 'success';
    $response['message'] = 'Créneaux récupérés';
    $response['data'] = $slots;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Aucun créneau trouvé';
}
$json = json_encode($response, JSON_PRETTY_PRINT);
header('Content-Length: ' . strlen($json));
echo $json;