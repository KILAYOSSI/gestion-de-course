<?php
// Contrôleur pour les statistiques

class StatistiquesController {

    private $achatModel;

    public function __construct() {
        global $pdo;
        $this->achatModel = new Achat($pdo);
    }

    // Afficher les statistiques
    public function index() {
        $depensesParMembre = $this->achatModel->depensesParMembre();
        $produitsPlusAchetes = $this->achatModel->produitsPlusAchetes();
        $depensesParCategorie = $this->achatModel->depensesParCategorie();
        $topProduit = $this->achatModel->getTopProduit();

        include 'app/views/statistiques/index.php';
    }
}
?>
