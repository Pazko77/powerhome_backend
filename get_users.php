<?php
require 'db_connect.php';

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');
$response = [];

$stmt = $pdo->query("SELECT * FROM user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($users) {
    $response['status'] = 'success';
    $response['message'] = 'Utilisateurs récupérés';
    $response['data'] = $users;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Aucun utilisateur trouvé';
}

$json = json_encode($response, JSON_PRETTY_PRINT);
header('Content-Length: ' . strlen($json));
echo $json;
?>
