<?php
require_once 'config/database.php';

try {
    global $pdo;
    $pdo->exec("ALTER TABLE LigneAchat MODIFY quantite DECIMAL(10,2) NOT NULL CHECK (quantite > 0)");
    echo "Migration réussie : colonne quantite changée en DECIMAL(10,2).\n";
} catch (PDOException $e) {
    echo "Erreur lors de la migration : " . $e->getMessage() . "\n";
}
?>
