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
        $topProduit = $this->achatModel->getTopProduit();
        $totalDepenses = $this->achatModel->getTotalDepenses();
        $totalAchats = $this->achatModel->getTotalAchats();
        $evolutionAchats = $this->achatModel->getEvolutionAchats();

        include 'app/views/statistiques/index.php';
    }
}
?>
