<?php
// Contrôleur pour les achats

class AchatsController {

    // Afficher la liste des achats
    public function index() {
        require_once 'app/models/Achat.php';
        $achatModel = new Achat();
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';
        $achats = $achatModel->getAllSorted($sort);

        require_once 'app/views/achats/index.php';
    }

    // Afficher le formulaire d'ajout
    public function ajouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/models/Achat.php';
            $achatModel = new Achat();

            $nomProduit = $_POST['nom_produit'];
            $prix = $_POST['prix'];
            $dateAchat = $_POST['date_achat'];

            $achatModel->ajouter($nomProduit, $prix, $dateAchat);
            $_SESSION['message'] = 'Produit ajouté avec succès !';
            $_SESSION['message_type'] = 'success';
            header('Location: index.php?controller=achats&action=index');
            exit();
        } else {
            require_once 'app/views/achats/ajouter.php';
        }
    }

    // Afficher le formulaire de modification
    public function modifier() {
        require_once 'app/models/Achat.php';
        $achatModel = new Achat();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
            $nomProduit = $_POST['nom_produit'];
            $prix = $_POST['prix'];
            $dateAchat = $_POST['date_achat'];

            $success = $achatModel->modifier($id, $nomProduit, $prix, $dateAchat);

            if ($success) {
                $_SESSION['message'] = 'Mise à jour avec succès !';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Erreur lors de la mise à jour.';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=achats&action=index');
            exit();
        } else {
            $id = $_GET['id'];
            $achat = $achatModel->getById($id);
            require_once 'app/views/achats/modifier.php';
        }
    }

    // Supprimer un achat
    public function supprimer() {
        require_once 'app/models/Achat.php';
        $achatModel = new Achat();

        $id = $_GET['id'];
        $achatModel->supprimer($id);

        $_SESSION['message'] = 'Suppression effectuée avec succès !';
        $_SESSION['message_type'] = 'success';
        header('Location: index.php?controller=achats&action=index');
        exit();
    }
}
?>
