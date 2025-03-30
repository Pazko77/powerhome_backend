<?php
require 'db_connect.php';

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();

header('Content-Type: application/json');
$response = [];

$stmt = $pdo->query("SELECT * FROM appliance");
$appliances = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($appliances) {
    $response['status'] = 'success';
    $response['message'] = 'Appareils récupérés';
    $response['data'] = $appliances;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Aucun appareil trouvé';
}
$json = json_encode($response, JSON_PRETTY_PRINT);
header('Content-Length: ' . strlen($json));
echo $json;
