<?php
// Modèle pour les achats

class Achat extends Model {

    // Récupérer tous les achats avec les détails des produits et membres
    public function getAllWithDetails() {
        $stmt = $this->pdo->query("
            SELECT a.*, p.nom as produit_nom, c.nom as categorie_nom, m.nom as membre_nom
            FROM achats a
            JOIN produits p ON a.produit_id = p.id
            JOIN categories c ON p.categorie_id = c.id
            JOIN membres m ON a.membre_id = m.id
            ORDER BY a.date_achat DESC, a.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    // Ajouter un nouvel achat
    public function ajouter($produit_id, $membre_id, $quantite, $prix, $date_achat) {
        return $this->insert('achats', [
            'produit_id' => $produit_id,
            'membre_id' => $membre_id,
            'quantite' => $quantite,
            'prix' => $prix,
            'date_achat' => $date_achat
        ]);
    }

    // Modifier un achat
    public function modifier($id, $produit_id, $membre_id, $quantite, $prix, $date_achat) {
        $this->update('achats', $id, [
            'produit_id' => $produit_id,
            'membre_id' => $membre_id,
            'quantite' => $quantite,
            'prix' => $prix,
            'date_achat' => $date_achat
        ]);
    }

    // Supprimer un achat
    public function supprimer($id) {
        $this->delete('achats', $id);
    }

    // Statistiques : Dépenses par membre
    public function depensesParMembre() {
        $stmt = $this->pdo->query("
            SELECT m.nom, SUM(a.quantite * a.prix) as total_depenses
            FROM achats a
            JOIN membres m ON a.membre_id = m.id
            GROUP BY m.id, m.nom
            ORDER BY total_depenses DESC
        ");
        return $stmt->fetchAll();
    }

    // Statistiques : Produits les plus achetés
    public function produitsPlusAchetes() {
        $stmt = $this->pdo->query("
            SELECT p.nom, SUM(a.quantite) as total_quantite
            FROM achats a
            JOIN produits p ON a.produit_id = p.id
            GROUP BY p.id, p.nom
            ORDER BY total_quantite DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    // Statistiques : Dépenses par catégorie
    public function depensesParCategorie() {
        $stmt = $this->pdo->query("
            SELECT c.nom, SUM(a.quantite * a.prix) as total_depenses
            FROM achats a
            JOIN produits p ON a.produit_id = p.id
            JOIN categories c ON p.categorie_id = c.id
            GROUP BY c.id, c.nom
            ORDER BY total_depenses DESC
        ");
        return $stmt->fetchAll();
    }

    // Fonction pour obtenir le top produit (produit le plus acheté)
    public function getTopProduit() {
        $produits = $this->produitsPlusAchetes();
        return $produits[0] ?? null;
    }
}
?>
