<?php
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h2 class="mb-0">
            <i class="fas fa-edit me-2"></i>
            Modifier un Achat
        </h2>
    </div>
    <div class="card-body">
        <form method="POST" action="index.php?controller=achats&action=modifier&id=<?php echo $achat['id']; ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nom_produit" class="form-label">
                            <i class="fas fa-box me-1"></i>Nom du produit
                        </label>
                        <input type="text" class="form-control" id="nom_produit" name="nom_produit" value="<?php echo htmlspecialchars($achat['nom_produit']); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="prix" class="form-label">
                            <i class="fas fa-money-bill me-1"></i>Prix (FCFA)
                        </label>
                        <input type="number" class="form-control" id="prix" name="prix" value="<?php echo $achat['prix']; ?>" min="0" step="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="date_achat" class="form-label">
                            <i class="fas fa-calendar me-1"></i>Date de l'achat
                        </label>
                        <input type="date" class="form-control" id="date_achat" name="date_achat" value="<?php echo $achat['date_achat']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?controller=achats&action=index" class="btn">
                    <i class="fas fa-arrow-left me-1"></i>Annuler
                </a>
                <button type="submit" class="btn">
                    <i class="fas fa-save me-1"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
