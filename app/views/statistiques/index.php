<?php
ob_start();
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-chart-bar text-primary me-2"></i>
            Statistiques des Achats
        </h2>
    </div>
</div>

<div class="stats-container">
    <div class="row">
        <div class="col-md-4">
            <div class="stats-card-transparent">
                <div class="text-center">
                    <i class="fas fa-trophy fa-3x mb-3"></i>
                    <h3>Produit le plus acheté</h3>
                    <?php if ($topProduit): ?>
                        <h4><?php echo htmlspecialchars($topProduit['nom_produit']); ?></h4>
                        <p><?php echo $topProduit['nombre_achats']; ?> achats</p>
                    <?php else: ?>
                        <p>Aucune donnée</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card-transparent">
                <div class="text-center">
                    <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                    <h3>Bilan Financier</h3>
                    <h4><?php echo number_format($totalDepenses, 0, ',', ' '); ?> FCFA</h4>
                    <p>Dépenses totales</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card-transparent">
                <div class="text-center">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <h3>Achats enregistrés</h3>
                    <h4><?php echo $totalAchats; ?></h4>
                    <p>Achats totaux</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-line me-2"></i>Évolution des Achats</h3>
            </div>
            <div class="card-body">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('evolutionChart');
    if (ctx) {
        const evolutionData = <?php echo json_encode($evolutionAchats); ?>;
        if (evolutionData && evolutionData.length > 0) {
            const labels = evolutionData.map(item => item.mois);
            const data = evolutionData.map(item => item.total);

            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Dépenses (FCFA)',
                        data: data,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            ctx.parentNode.innerHTML = '<p class="text-center text-muted">Aucune donnée d\'évolution disponible pour le moment. Ajoutez des achats pour voir le graphique.</p>';
        }
    }
</script>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
