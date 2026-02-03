<?php
ob_start();
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-shopping-bag text-primary me-2"></i>Historique des Achats</h2>
            <a href="index.php?controller=achats&action=ajouter" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Ajouter un Achat
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>ID Achat</th>
                                <th>Date</th>
                                <th>Membre</th>
                                <th>Produits</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentAchatId = null;
                            $achatTotal = 0;
                            $produitsList = [];
                            $numero = 1;
                            $totalGeneral = 0;
                            foreach ($achats as $achat):
                                if ($currentAchatId !== $achat['id']) {
                                    // Afficher la ligne précédente si elle existe
                                    if ($currentAchatId !== null) {
                                        echo '<tr>';
                                        echo '<td>' . $numero++ . '</td>';
                                        echo '<td>' . $currentAchatId . '</td>';
                                        echo '<td>' . date('d/m/Y', strtotime($previousAchat['date_achat'])) . '</td>';
                                        echo '<td>' . htmlspecialchars($previousAchat['membre_nom']) . '</td>';
                                        echo '<td>';
                                        foreach ($produitsList as $produit) {
                                            echo '<small class="d-block">' . htmlspecialchars($produit['nom']) . ' (' . $produit['quantite'] . ' x ' . number_format($produit['prix'], 2, ',', ' ') . ' €)</small>';
                                        }
                                        echo '</td>';
                                        echo '<td><strong>' . number_format($achatTotal, 2, ',', ' ') . ' €</strong></td>';
                                        echo '<td>';
                                        echo '<a href="index.php?controller=achats&action=modifier&id=' . $currentAchatId . '" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>';
                                        echo '<a href="index.php?controller=achats&action=supprimer&id=' . $currentAchatId . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet achat ?\')"><i class="fas fa-trash"></i></a>';
                                        echo '</td>';
                                        echo '</tr>';
                                        $totalGeneral += $achatTotal;
                                    }

                                    // Réinitialiser pour le nouvel achat
                                    $currentAchatId = $achat['id'];
                                    $achatTotal = 0;
                                    $produitsList = [];
                                    $previousAchat = $achat;
                                }

                                // Accumuler les produits et le total
                                $produitsList[] = [
                                    'nom' => $achat['produit_nom'],
                                    'quantite' => $achat['quantite'],
                                    'prix' => $achat['prix']
                                ];
                                $achatTotal += $achat['total_ligne'];
                            endforeach;

                            // Afficher le dernier achat
                            if ($currentAchatId !== null) {
                                echo '<tr>';
                                echo '<td>' . $numero++ . '</td>';
                                echo '<td>' . $currentAchatId . '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($previousAchat['date_achat'])) . '</td>';
                                echo '<td>' . htmlspecialchars($previousAchat['membre_nom']) . '</td>';
                                echo '<td>';
                                foreach ($produitsList as $produit) {
                                    echo '<small class="d-block">' . htmlspecialchars($produit['nom']) . ' (' . $produit['quantite'] . ' x ' . number_format($produit['prix'], 2, ',', ' ') . ' €)</small>';
                                }
                                echo '</td>';
                                echo '<td><strong>' . number_format($achatTotal, 2, ',', ' ') . ' €</strong></td>';
                                echo '<td>';
                                echo '<a href="index.php?controller=achats&action=modifier&id=' . $currentAchatId . '" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>';
                                echo '<a href="index.php?controller=achats&action=supprimer&id=' . $currentAchatId . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet achat ?\')"><i class="fas fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                                $totalGeneral += $achatTotal;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalGeneral > 0): ?>
                <div class="mt-3 p-3 bg-light rounded">
                    <h5 class="mb-0">Total des dépenses : <strong><?php echo number_format($totalGeneral, 2, ',', ' '); ?> €</strong></h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Produits les plus achetés</h5>
            </div>
            <div class="card-body">
                <?php
                $achatModel = new Achat();
                $topProduits = $achatModel->produitsPlusAchetes();
                if (!empty($topProduits)):
                ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($topProduits as $produit): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($produit['nom']); ?>
                        <span class="badge bg-primary rounded-pill"><?php echo $produit['total_quantite']; ?> unités</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-muted">Aucun produit acheté pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Dépenses par membre</h5>
            </div>
            <div class="card-body">
                <?php
                $depensesMembres = $achatModel->depensesParMembre();
                if (!empty($depensesMembres)):
                ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($depensesMembres as $membre): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($membre['nom']); ?>
                        <span class="badge bg-success rounded-pill"><?php echo number_format($membre['total_depenses'], 2, ',', ' '); ?> €</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-3">
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="fas fa-print me-1"></i>Imprimer les dépenses
                    </button>
                </div>
                <?php else: ?>
                <p class="text-muted">Aucune dépense enregistrée pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
