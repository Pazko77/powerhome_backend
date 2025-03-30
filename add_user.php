<?php
require 'db_connect.php';;

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])) {
    $stmt = $pdo->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
    $json = json_encode(["message" => "Utilisateur ajouté"]);
} else {
    $json = json_encode(["error" => "Données incomplètes"]);
}
header('Content-Length: ' . strlen($json));
echo $json;
?>
