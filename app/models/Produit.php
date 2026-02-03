<?php
// Modèle pour les produits

class Produit extends Model {

    // Récupérer tous les produits avec leur catégorie
    public function getAllWithCategories() {
        $stmt = $this->pdo->query("
            SELECT p.*, c.nom as categorie_nom
            FROM produits p
            LEFT JOIN categories c ON p.categorie_id = c.id
            ORDER BY p.nom
        ");
        return $stmt->fetchAll();
    }

    // Ajouter un nouveau produit
    public function ajouter($nom, $categorie_id) {
        return $this->insert('produits', [
            'nom' => $nom,
            'categorie_id' => $categorie_id
        ]);
    }

    // Modifier un produit
    public function modifier($id, $nom, $categorie_id) {
        $this->update('produits', $id, [
            'nom' => $nom,
            'categorie_id' => $categorie_id
        ]);
    }

    // Supprimer un produit
    public function supprimer($id) {
        $this->delete('produits', $id);
    }
}
?>
