
<?php
ob_start();
?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert" style="border-radius: 10px; margin-bottom: 20px;">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
<?php endif; ?>

<div class="card">
    <div class="card-header text-center" style="background: #42a5f5; border-radius: 20px 20px 0 0;">
        <h2 class="mb-0" style="color: white; font-weight: bold; animation: icePulse 2s ease-in-out infinite;">
            <i class="fas fa-shopping-bag me-2"></i>
            Kilys Startup - Historique des Achats
        </h2>
    </div>
    <div class="card-body" style="background: rgba(255, 255, 255, 0.9); border-radius: 0 0 20px 20px; position: relative; overflow: hidden;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted mb-2" style="color: #6c5ce7; font-weight: 500;">Liste de tous les achats effectués</p>
                <form method="GET" action="index.php" class="d-flex align-items-center">
                    <input type="hidden" name="controller" value="achats">
                    <input type="hidden" name="action" value="index">
                    <label for="sort" class="me-2" style="color: #42a5f5; font-weight: 500;">Trier par :</label>
                    <select name="sort" id="sort" class="form-select form-select-sm me-2" style="width: auto; border-color: #42a5f5;" onchange="this.form.submit()">
                        <option value="date_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_desc') ? 'selected' : ''; ?>>Date (récent d'abord)</option>
                        <option value="date_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'date_asc') ? 'selected' : ''; ?>>Date (ancien d'abord)</option>
                        <option value="prix_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'prix_desc') ? 'selected' : ''; ?>>Prix (décroissant)</option>
                        <option value="prix_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'prix_asc') ? 'selected' : ''; ?>>Prix (croissant)</option>
                        <option value="nom_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nom_asc') ? 'selected' : ''; ?>>Nom (A-Z)</option>
                        <option value="nom_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nom_desc') ? 'selected' : ''; ?>>Nom (Z-A)</option>
                    </select>
                </form>
            </div>
            <a href="index.php?controller=achats&action=ajouter" class="btn" style="background: linear-gradient(45deg, #42a5f5, #1e88e5); border: none; border-radius: 25px; color: white; transition: transform 0.3s ease;">
                <i class="fas fa-plus me-2"></i>Ajouter un achat
            </a>
        </div>

        <?php if (empty($achats)): ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun achat trouvé</h4>
                <p class="text-muted">Commencez par ajouter votre premier achat !</p>
                <a href="index.php?controller=achats&action=ajouter" class="btn">
                    <i class="fas fa-plus me-2"></i>Ajouter un achat
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background: rgba(66, 165, 245, 0.8); color: white;">
                        <tr>
                            <th><i class="fas fa-calendar me-1"></i>Date</th>
                            <th><i class="fas fa-box me-1"></i>Produit</th>
                            <th><i class="fas fa-money-bill me-1"></i>Prix (FCFA)</th>
                            <th><i class="fas fa-cogs me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($achats as $achat): ?>
                            <tr>
                                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($achat['date_achat']))); ?></td>
                                <td><?php echo htmlspecialchars($achat['nom_produit']); ?></td>
                                <td><?php echo number_format($achat['prix'], 0, ',', ' ') . ' FCFA'; ?></td>
                                <td>
                                    <a href="index.php?controller=achats&action=modifier&id=<?php echo $achat['id']; ?>" class="btn btn-primary btn-sm me-1">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="index.php?controller=achats&action=supprimer&id=<?php echo $achat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet achat ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
