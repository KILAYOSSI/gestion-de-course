<?php
$servername = "localhost";
$username = "root"; // ou votre nom d'utilisateur MySQL
$password = ""; // ou votre mot de passe MySQL
$dbname = "gestion de course";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    global $pdo;
    $pdo = $conn;
} catch (PDOException $e) {
    echo "Connexion échouée: " . $e->getMessage();
}
?>
