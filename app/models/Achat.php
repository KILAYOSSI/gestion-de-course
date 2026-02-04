<?php
// Modèle pour les achats

class Achat extends Model {

    // Récupérer tous les achats triés par date décroissante
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Achats ORDER BY date_achat DESC, id DESC");
        return $stmt->fetchAll();
    }

    // Récupérer tous les achats avec tri personnalisé
    public function getAllSorted($sort = 'date_desc') {
        $orderBy = 'date_achat DESC, id DESC';
        switch ($sort) {
            case 'date_asc':
                $orderBy = 'date_achat ASC, id ASC';
                break;
            case 'prix_desc':
                $orderBy = 'prix DESC, date_achat DESC';
                break;
            case 'prix_asc':
                $orderBy = 'prix ASC, date_achat DESC';
                break;
            case 'nom_asc':
                $orderBy = 'nom_produit ASC, date_achat DESC';
                break;
            case 'nom_desc':
                $orderBy = 'nom_produit DESC, date_achat DESC';
                break;
            default:
                $orderBy = 'date_achat DESC, id DESC';
        }
        $stmt = $this->pdo->prepare("SELECT * FROM Achats ORDER BY $orderBy");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ajouter un nouvel achat
    public function ajouter($nomProduit, $prix, $dateAchat) {
        $stmt = $this->pdo->prepare("INSERT INTO Achats (nom_produit, prix, date_achat) VALUES (?, ?, ?)");
        return $stmt->execute([$nomProduit, $prix, $dateAchat]);
    }

    // Obtenir le produit le plus acheté (par nombre d'occurrences)
    public function getTopProduit() {
        $stmt = $this->pdo->query("
            SELECT nom_produit, COUNT(*) as nombre_achats
            FROM Achats
            GROUP BY nom_produit
            ORDER BY nombre_achats DESC
            LIMIT 1
        ");
        return $stmt->fetch();
    }

    // Calculer le montant total des dépenses
    public function getTotalDepenses() {
        $stmt = $this->pdo->query("SELECT SUM(prix) as total FROM Achats");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // Obtenir le nombre total d'achats enregistrés
    public function getTotalAchats() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Achats");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // Mettre à jour un achat
    public function modifier($id, $nomProduit, $prix, $dateAchat) {
        $stmt = $this->pdo->prepare("UPDATE Achats SET nom_produit = ?, prix = ?, date_achat = ? WHERE id = ?");
        return $stmt->execute([$nomProduit, $prix, $dateAchat, $id]);
    }

    // Supprimer un achat
    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Achats WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Récupérer un achat par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Achats WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Obtenir les données pour le graphique d'évolution
    public function getEvolutionAchats() {
        $stmt = $this->pdo->query("
            SELECT DATE_FORMAT(date_achat, '%Y-%m') as mois, SUM(prix) as total
            FROM Achats
            GROUP BY DATE_FORMAT(date_achat, '%Y-%m')
            ORDER BY mois
        ");
        return $stmt->fetchAll();
    }
}
?>
