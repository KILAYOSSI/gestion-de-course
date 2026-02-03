<?php
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Ajouter un Nouvel Achat</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=achats&action=ajouter" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="produit_id" class="form-label">Produit</label>
                            <select class="form-select" id="produit_id" name="produit_id" required>
                                <option value="">Choisir un produit</option>
                                <?php foreach ($produits as $produit): ?>
                                <option value="<?php echo $produit['id']; ?>"><?php echo htmlspecialchars($produit['nom']); ?> (<?php echo htmlspecialchars($produit['categorie_nom']); ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="membre_id" class="form-label">Membre</label>
                            <select class="form-select" id="membre_id" name="membre_id" required>
                                <option value="">Choisir un membre</option>
                                <?php foreach ($membres as $membre): ?>
                                <option value="<?php echo $membre['id']; ?>"><?php echo htmlspecialchars($membre['nom']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantite" class="form-label">Quantité</label>
                            <input type="number" class="form-control" id="quantite" name="quantite" step="0.01" min="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="prix" class="form-label">Prix unitaire (€)</label>
                            <input type="number" class="form-control" id="prix" name="prix" step="0.01" min="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date_achat" class="form-label">Date d'achat</label>
                            <input type="date" class="form-control" id="date_achat" name="date_achat" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=achats&action=index" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Ajouter l'Achat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
