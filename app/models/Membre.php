<?php
// Modèle pour les membres

class Membre extends Model {

    // Récupérer tous les membres
    public function getAll() {
        $stmt = $this->pdo->query("SELECT idMembre as id, CONCAT(nom, ' ', prenom) as nom_complet, nom, prenom FROM Membre ORDER BY nom, prenom");
        return $stmt->fetchAll();
    }

    // Récupérer un membre par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT idMembre as id, CONCAT(nom, ' ', prenom) as nom_complet, nom, prenom FROM Membre WHERE idMembre = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Ajouter un nouveau membre
    public function ajouter($nom, $prenom) {
        $stmt = $this->pdo->prepare("INSERT INTO Membre (nom, prenom) VALUES (?, ?)");
        $stmt->execute([$nom, $prenom]);
        return $this->pdo->lastInsertId();
    }

    // Modifier un membre
    public function modifier($id, $nom, $prenom) {
        $stmt = $this->pdo->prepare("UPDATE Membre SET nom = ?, prenom = ? WHERE idMembre = ?");
        return $stmt->execute([$nom, $prenom, $id]);
    }

    // Supprimer un membre
    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Membre WHERE idMembre = ?");
        return $stmt->execute([$id]);
    }
}
?>
