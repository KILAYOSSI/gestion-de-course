<?php
// Contrôleur pour les achats

class AchatsController {

    private $achatModel;
    private $produitModel;
    private $membreModel;

    public function __construct() {
        global $pdo;
        $this->achatModel = new Achat($pdo);
        $this->produitModel = new Produit($pdo);
        $this->membreModel = new Membre($pdo);
    }

    // Afficher la liste des achats
    public function index() {
        $achats = $this->achatModel->getAllWithDetails();
        include 'app/views/achats/index.php';
    }

    // Afficher le formulaire d'ajout
    public function ajouter() {
        $produits = $this->produitModel->getAllWithCategories();
        $membres = $this->membreModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMembre = $_POST['idMembre'];
            $dateAchat = $_POST['dateAchat'];

            // Récupérer les lignes d'achat
            $lignes = [];
            if (isset($_POST['produits']) && is_array($_POST['produits'])) {
                foreach ($_POST['produits'] as $index => $idProduit) {
                    if (!empty($idProduit) && isset($_POST['quantites'][$index]) && isset($_POST['prix'][$index])) {
                        $quantite = floatval($_POST['quantites'][$index]);
                        $prix = floatval($_POST['prix'][$index]);
                        if ($quantite <= 0 || $prix < 0) {
                            $error = "La quantité doit être supérieure à 0 et le prix doit être positif ou nul.";
                            break;
                        }
                        $lignes[] = [
                            'idProduit' => $idProduit,
                            'quantite' => $quantite,
                            'prix' => $prix
                        ];
                    }
                }
            }

            if (!empty($lignes)) {
                try {
                    $this->achatModel->ajouter($idMembre, $dateAchat, $lignes);
                    header('Location: index.php?controller=achats&action=index');
                    exit;
                } catch (Exception $e) {
                    $error = "Erreur lors de l'ajout de l'achat : " . $e->getMessage();
                }
            } else {
                $error = "Veuillez ajouter au moins un produit à l'achat.";
            }
        }

        include 'app/views/achats/ajouter.php';
    }

    // Afficher le formulaire de modification
    public function modifier() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=achats&action=index');
            exit;
        }

        $achat = $this->achatModel->getById($id);
        if (!$achat) {
            header('Location: index.php?controller=achats&action=index');
            exit;
        }

        $produits = $this->produitModel->getAllWithCategories();
        $membres = $this->membreModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMembre = $_POST['idMembre'];
            $dateAchat = $_POST['dateAchat'];

            // Récupérer les lignes d'achat
            $lignes = [];
            if (isset($_POST['produits']) && is_array($_POST['produits'])) {
                foreach ($_POST['produits'] as $index => $idProduit) {
                    if (!empty($idProduit) && isset($_POST['quantites'][$index]) && isset($_POST['prix'][$index])) {
                        $quantite = floatval($_POST['quantites'][$index]);
                        $prix = floatval($_POST['prix'][$index]);
                        if ($quantite <= 0 || $prix < 0) {
                            $error = "La quantité doit être supérieure à 0 et le prix doit être positif ou nul.";
                            break;
                        }
                        $lignes[] = [
                            'idProduit' => $idProduit,
                            'quantite' => $quantite,
                            'prix' => $prix
                        ];
                    }
                }
            }

            if (!empty($lignes)) {
                try {
                    $this->achatModel->modifier($id, $idMembre, $dateAchat, $lignes);
                    header('Location: index.php?controller=achats&action=index');
                    exit;
                } catch (Exception $e) {
                    $error = "Erreur lors de la modification de l'achat : " . $e->getMessage();
                }
            } else {
                $error = "Veuillez ajouter au moins un produit à l'achat.";
            }
        }

        include 'app/views/achats/modifier.php';
    }

    // Supprimer un achat
    public function supprimer() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $this->achatModel->supprimer($id);
            } catch (Exception $e) {
                // Gérer l'erreur si nécessaire
            }
        }
        header('Location: index.php?controller=achats&action=index');
        exit;
    }
}
?>
