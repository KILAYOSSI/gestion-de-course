<?php
$servername = "localhost";
$password = "root"; // ou votre mot de passe MySQL
$dbname = "ecole";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",  $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connexion échouée: " . $e->getMessage();
}
?>
