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
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Membre</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($achats as $achat): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($achat['date_achat'])); ?></td>
                                <td><?php echo htmlspecialchars($achat['produit_nom']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($achat['categorie_nom']); ?></span></td>
                                <td><?php echo htmlspecialchars($achat['membre_nom']); ?></td>
                                <td><?php echo $achat['quantite']; ?></td>
                                <td><?php echo number_format($achat['prix'], 2, ',', ' '); ?> €</td>
                                <td><strong><?php echo number_format($achat['quantite'] * $achat['prix'], 2, ',', ' '); ?> €</strong></td>
                                <td>
                                    <a href="index.php?controller=achats&action=modifier&id=<?php echo $achat['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?controller=achats&action=supprimer&id=<?php echo $achat['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet achat ?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
