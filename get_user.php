<?php
// db_connect.php : Connexion à la base de données
include 'db_connect.php';

$db_connect = new DB_Connect();
$pdo = $db_connect->connecter();
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer l'email et le mot de passe depuis la méthode POST
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo json_encode(["error" => "Email and password are required"]);
        exit;
    }

    try {
        // Préparer la requête pour récupérer l'utilisateur par email
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["error" => "User not found"]) ;
            exit;
        }

        // Vérifier que le mot de passe correspond
        if (!password_verify($password, $user['password'])) {
            echo json_encode(["error" => "Invalid password"]);
            exit;
        }

        // Récupérer l'habitat de l'utilisateur
        $habitat_id = $user['habitat_id'];
        $stmt_habitat = $pdo->prepare("SELECT * FROM habitat WHERE id = ?");
        $stmt_habitat->execute([$habitat_id]);
        $habitat = $stmt_habitat->fetch(PDO::FETCH_ASSOC);

        if (!$habitat) {
            echo json_encode(["error" => "Habitat not found"]);
            exit;
        }

        // Récupérer les appareils liés à l'habitat
        $stmt_appliances = $pdo->prepare("SELECT * FROM appliance WHERE habitat_id = ?");
        $stmt_appliances->execute([$habitat_id]);
        $appliances = $stmt_appliances->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les données au format JSON
        $response = [
            "user" => $user,
            "habitat" => $habitat,
            "appliances" => $appliances
        ];

        $json = json_encode($response, JSON_PRETTY_PRINT);
        header('Content-Length: ' . strlen($json));
        echo $json;

    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
?>
