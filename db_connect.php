<?php
class db_connect
{
    private $host = 'mysql-pazko.alwaysdata.net'; // Remplace par ton hôte Alwaysdata
    private $dbname = 'pazko_powerhome'; // Remplace par le nom de ta base
    private $username = 'pazko'; // Remplace par ton utilisateur
    private $password = 'Vyvwuf87'; // Remplace par ton mot de passe
    private $charset = 'utf8mb4';
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    private $pdo;
    private $dsn;

    public function __construct()
    {
        $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $this->connecter();
    }

    public function connecter(): PDO
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
            } catch (PDOException $e) {
                throw new Exception("Connexion à la base de données échouée : " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
