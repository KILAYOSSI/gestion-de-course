<?php
ob_start();
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fas fa-chart-pie text-primary me-2"></i>Statistiques des Achats</h2>

        <!-- Top Produit -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stats-card text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy fa-3x mb-3"></i>
                        <h5 class="card-title">Produit le Plus Acheté</h5>
                        <?php if ($topProduit): ?>
                        <h3><?php echo htmlspecialchars($topProduit['nom']); ?></h3>
                        <p class="mb-0"><?php echo $topProduit['total_quantite']; ?> unités</p>
                        <?php else: ?>
                        <p class="mb-0">Aucun achat enregistré</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-users me-2"></i>Dépenses par Membre</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="depensesMembreChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-tags me-2"></i>Dépenses par Catégorie</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="depensesCategorieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table des produits les plus achetés -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-star me-2"></i>Top 10 des Produits les Plus Achetés</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Rang</th>
                                        <th>Produit</th>
                                        <th>Quantité Totale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rang = 1; ?>
                                    <?php foreach ($produitsPlusAchetes as $produit): ?>
                                    <tr>
                                        <td>
                                            <?php if ($rang <= 3): ?>
                                            <i class="fas fa-medal text-warning"></i> <?php echo $rang; ?>
                                            <?php else: ?>
                                            <?php echo $rang; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                                        <td><?php echo $produit['total_quantite']; ?> unités</td>
                                    </tr>
                                    <?php $rang++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des dépenses par membre
    const depensesMembreData = <?php echo json_encode($depensesParMembre); ?>;
    const ctxMembre = document.getElementById('depensesMembreChart').getContext('2d');
    new Chart(ctxMembre, {
        type: 'pie',
        data: {
            labels: depensesMembreData.map(item => item.nom),
            datasets: [{
                data: depensesMembreData.map(item => item.total_depenses),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Graphique des dépenses par catégorie
    const depensesCategorieData = <?php echo json_encode($depensesParCategorie); ?>;
    const ctxCategorie = document.getElementById('depensesCategorieChart').getContext('2d');
    new Chart(ctxCategorie, {
        type: 'doughnut',
        data: {
            labels: depensesCategorieData.map(item => item.nom),
            datasets: [{
                data: depensesCategorieData.map(item => item.total_depenses),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
