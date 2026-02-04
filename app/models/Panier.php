<?php
// Modèle pour le panier d'achats

class Panier {

    public function __construct() {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
    }

    // Ajouter un produit au panier
    public function addProduit($nom, $prix) {
        $_SESSION['panier'][] = [
            'nom' => $nom,
            'prix' => $prix
        ];
    }

    // Récupérer le contenu du panier
    public function getPanier() {
        return $_SESSION['panier'];
    }

    // Calculer le total du panier
    public function getTotal() {
        $total = 0;
        foreach ($_SESSION['panier'] as $produit) {
            $total += $produit['prix'];
        }
        return $total;
    }

    // Supprimer un produit du panier par index
    public function removeProduit($index) {
        if (isset($_SESSION['panier'][$index])) {
            unset($_SESSION['panier'][$index]);
            $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer
        }
    }

    // Vider le panier
    public function viderPanier() {
        $_SESSION['panier'] = [];
    }
}
?>
