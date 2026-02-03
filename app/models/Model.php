<?php
// Classe de base pour tous les modèles

class Model {
    protected $pdo;

    public function __construct($pdo = null) {
        if ($pdo === null) {
            require_once 'config/database.php';
            global $pdo;
            $this->pdo = $pdo;
        } else {
            $this->pdo = $pdo;
        }
    }

    // Méthode générique pour sélectionner tous les enregistrements
    public function selectAll($table, $orderBy = 'id') {
        $stmt = $this->pdo->query("SELECT * FROM $table ORDER BY $orderBy");
        return $stmt->fetchAll();
    }

    // Méthode générique pour sélectionner un enregistrement par ID
    public function selectById($table, $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Méthode générique pour insérer un enregistrement
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = str_repeat('?, ', count($data) - 1) . '?';
        $stmt = $this->pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    // Méthode générique pour mettre à jour un enregistrement
    public function update($table, $id, $data) {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $stmt = $this->pdo->prepare("UPDATE $table SET $set WHERE id = ?");
        $stmt->execute(array_merge(array_values($data), [$id]));
        return $stmt->rowCount();
    }

    // Méthode générique pour supprimer un enregistrement
    public function delete($table, $id) {
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>
