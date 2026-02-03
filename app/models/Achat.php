<?php
// Modèle pour les achats

class Achat extends Model {

    // Récupérer tous les achats avec les détails des produits et membres
    public function getAllWithDetails() {
        $stmt = $this->pdo->query("
            SELECT
                a.idAchat as id,
                a.dateAchat as date_achat,
                CONCAT(m.nom, ' ', m.prenom) as membre_nom,
                la.idProduit,
                p.nomProduit as produit_nom,
                c.nomCategorie as categorie_nom,
                la.quantite,
                la.prixUnitaire as prix,
                (la.quantite * la.prixUnitaire) as total_ligne
            FROM Achat a
            JOIN Membre m ON a.idMembre = m.idMembre
            JOIN LigneAchat la ON a.idAchat = la.idAchat
            JOIN Produit p ON la.idProduit = p.idProduit
            JOIN Categorie c ON p.idCategorie = c.idCategorie
            ORDER BY a.dateAchat DESC, a.idAchat DESC, la.idLigne
        ");
        return $stmt->fetchAll();
    }

    // Récupérer un achat spécifique avec ses lignes
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT
                a.idAchat as id,
                a.dateAchat as date_achat,
                a.idMembre,
                m.nom,
                m.prenom,
                CONCAT(m.nom, ' ', m.prenom) as membre_nom
            FROM Achat a
            JOIN Membre m ON a.idMembre = m.idMembre
            WHERE a.idAchat = ?
        ");
        $stmt->execute([$id]);
        $achat = $stmt->fetch();

        if ($achat) {
            // Récupérer les lignes d'achat
            $stmt = $this->pdo->prepare("
                SELECT
                    la.idLigne,
                    la.idProduit,
                    p.nomProduit as produit_nom,
                    c.nomCategorie as categorie_nom,
                    la.quantite,
                    la.prixUnitaire as prix
                FROM LigneAchat la
                JOIN Produit p ON la.idProduit = p.idProduit
                JOIN Categorie c ON p.idCategorie = c.idCategorie
                WHERE la.idAchat = ?
                ORDER BY la.idLigne
            ");
            $stmt->execute([$id]);
            $achat['lignes'] = $stmt->fetchAll();
        }

        return $achat;
    }

    // Ajouter un nouvel achat avec ses lignes
    public function ajouter($idMembre, $dateAchat, $lignes) {
        try {
            $this->pdo->beginTransaction();

            // Insérer l'achat
            $stmt = $this->pdo->prepare("INSERT INTO Achat (dateAchat, idMembre) VALUES (?, ?)");
            $stmt->execute([$dateAchat, $idMembre]);
            $idAchat = $this->pdo->lastInsertId();

            // Insérer les lignes d'achat
            $stmt = $this->pdo->prepare("INSERT INTO LigneAchat (idAchat, idProduit, quantite, prixUnitaire) VALUES (?, ?, ?, ?)");
            foreach ($lignes as $ligne) {
                $stmt->execute([$idAchat, $ligne['idProduit'], $ligne['quantite'], $ligne['prix']]);
            }

            $this->pdo->commit();
            return $idAchat;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Modifier un achat
    public function modifier($id, $idMembre, $dateAchat, $lignes) {
        try {
            $this->pdo->beginTransaction();

            // Modifier l'achat
            $stmt = $this->pdo->prepare("UPDATE Achat SET dateAchat = ?, idMembre = ? WHERE idAchat = ?");
            $stmt->execute([$dateAchat, $idMembre, $id]);

            // Supprimer les anciennes lignes
            $stmt = $this->pdo->prepare("DELETE FROM LigneAchat WHERE idAchat = ?");
            $stmt->execute([$id]);

            // Insérer les nouvelles lignes
            $stmt = $this->pdo->prepare("INSERT INTO LigneAchat (idAchat, idProduit, quantite, prixUnitaire) VALUES (?, ?, ?, ?)");
            foreach ($lignes as $ligne) {
                $stmt->execute([$id, $ligne['idProduit'], $ligne['quantite'], $ligne['prix']]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Supprimer un achat
    public function supprimer($id) {
        try {
            $this->pdo->beginTransaction();

            // Supprimer les lignes d'achat d'abord (contrainte de clé étrangère)
            $stmt = $this->pdo->prepare("DELETE FROM LigneAchat WHERE idAchat = ?");
            $stmt->execute([$id]);

            // Supprimer l'achat
            $stmt = $this->pdo->prepare("DELETE FROM Achat WHERE idAchat = ?");
            $result = $stmt->execute([$id]);

            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Statistiques : Dépenses par membre
    public function depensesParMembre() {
        $stmt = $this->pdo->query("
            SELECT
                CONCAT(m.nom, ' ', m.prenom) as nom,
                SUM(la.quantite * la.prixUnitaire) as total_depenses
            FROM Achat a
            JOIN Membre m ON a.idMembre = m.idMembre
            JOIN LigneAchat la ON a.idAchat = la.idAchat
            GROUP BY m.idMembre, m.nom, m.prenom
            ORDER BY total_depenses DESC
        ");
        return $stmt->fetchAll();
    }

    // Statistiques : Produits les plus achetés
    public function produitsPlusAchetes() {
        $stmt = $this->pdo->query("
            SELECT
                p.nomProduit as nom,
                SUM(la.quantite) as total_quantite
            FROM LigneAchat la
            JOIN Produit p ON la.idProduit = p.idProduit
            GROUP BY p.idProduit, p.nomProduit
            ORDER BY total_quantite DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    // Statistiques : Dépenses par catégorie
    public function depensesParCategorie() {
        $stmt = $this->pdo->query("
            SELECT
                c.nomCategorie as nom,
                SUM(la.quantite * la.prixUnitaire) as total_depenses
            FROM LigneAchat la
            JOIN Produit p ON la.idProduit = p.idProduit
            JOIN Categorie c ON p.idCategorie = c.idCategorie
            GROUP BY c.idCategorie, c.nomCategorie
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
