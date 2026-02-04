<?php
// Contrôleur pour le panier

class PanierController {

    // Afficher le contenu du panier
    public function index() {
        require_once 'app/models/Panier.php';
        $panierModel = new Panier();
        $panier = $panierModel->getPanier();
        $total = $panierModel->getTotal();

        require_once 'app/views/panier/index.php';
    }

    // Ajouter un produit au panier
    public function ajouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/models/Panier.php';
            $panierModel = new Panier();

            $nomProduit = $_POST['nom_produit'];
            $prix = $_POST['prix'];

            $panierModel->addProduit($nomProduit, $prix);

            // Rediriger vers la page d'historique des achats
            header('Location: index.php?controller=achats&action=index');
            exit();
        } else {
            // Afficher le formulaire d'ajout
            require_once 'app/views/panier/ajouter.php';
        }
    }

    // Supprimer un produit du panier
    public function supprimer() {
        require_once 'app/models/Panier.php';
        $panierModel = new Panier();

        $index = $_GET['index'];
        $panierModel->removeProduit($index);

        header('Location: index.php?controller=panier&action=index');
        exit();
    }

    // Vider le panier
    public function vider() {
        require_once 'app/models/Panier.php';
        $panierModel = new Panier();

        $panierModel->viderPanier();

        header('Location: index.php?controller=panier&action=index');
        exit();
    }

    // Valider le panier (ajouter les achats)
    public function valider() {
        require_once 'app/models/Panier.php';
        require_once 'app/models/Achat.php';

        $panierModel = new Panier();
        $achatModel = new Achat();

        $panier = $panierModel->getPanier();
        $dateAchat = date('Y-m-d');

        foreach ($panier as $produit) {
            $achatModel->ajouter($produit['nom'], $produit['prix'], $dateAchat);
        }

        $panierModel->viderPanier();

        header('Location: index.php?controller=achats&action=index');
        exit();
    }
}
?>
