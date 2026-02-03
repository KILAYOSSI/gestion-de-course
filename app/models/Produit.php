<?php
// Modèle pour les produits

class Produit extends Model {

    // Récupérer tous les produits avec leur catégorie
    public function getAllWithCategories() {
        $stmt = $this->pdo->query("
            SELECT p.idProduit as id, p.nomProduit as nom, p.idCategorie, c.nomCategorie as categorie_nom
            FROM Produit p
            LEFT JOIN Categorie c ON p.idCategorie = c.idCategorie
            ORDER BY p.nomProduit
        ");
        return $stmt->fetchAll();
    }

    // Récupérer un produit par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.idProduit as id, p.nomProduit as nom, p.idCategorie, c.nomCategorie as categorie_nom
            FROM Produit p
            LEFT JOIN Categorie c ON p.idCategorie = c.idCategorie
            WHERE p.idProduit = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Ajouter un nouveau produit
    public function ajouter($nom, $categorie_id) {
        $stmt = $this->pdo->prepare("INSERT INTO Produit (nomProduit, idCategorie) VALUES (?, ?)");
        $stmt->execute([$nom, $categorie_id]);
        return $this->pdo->lastInsertId();
    }

    // Modifier un produit
    public function modifier($id, $nom, $categorie_id) {
        $stmt = $this->pdo->prepare("UPDATE Produit SET nomProduit = ?, idCategorie = ? WHERE idProduit = ?");
        return $stmt->execute([$nom, $categorie_id, $id]);
    }

    // Supprimer un produit
    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Produit WHERE idProduit = ?");
        return $stmt->execute([$id]);
    }
}
?>
