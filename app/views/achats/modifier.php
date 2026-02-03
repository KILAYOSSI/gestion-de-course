<?php
ob_start();
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier l'Achat</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="index.php?controller=achats&action=modifier&id=<?php echo $achat['id']; ?>" method="POST" id="achatForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idMembre" class="form-label">Membre</label>
                            <select class="form-select" id="idMembre" name="idMembre" required>
                                <option value="">Choisir un membre</option>
                                <?php foreach ($membres as $membre): ?>
                                <option value="<?php echo $membre['id']; ?>" <?php echo ($membre['id'] == $achat['idMembre']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($membre['nom_complet']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dateAchat" class="form-label">Date d'achat</label>
                            <input type="date" class="form-control" id="dateAchat" name="dateAchat" value="<?php echo $achat['date_achat']; ?>" required>
                        </div>
                    </div>

                    <h5 class="mb-3">Produits de l'achat</h5>
                    <div id="produitsContainer">
                        <?php if (isset($achat['lignes']) && is_array($achat['lignes'])): ?>
                            <?php foreach ($achat['lignes'] as $index => $ligne): ?>
                            <div class="produit-row border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        <label class="form-label">Produit</label>
                                        <select class="form-select produit-select" name="produits[]" required>
                                            <option value="">Choisir un produit</option>
                                            <?php foreach ($produits as $produit): ?>
                                            <option value="<?php echo $produit['id']; ?>" <?php echo ($produit['id'] == $ligne['idProduit']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($produit['nom']); ?> (<?php echo htmlspecialchars($produit['categorie_nom']); ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Quantité</label>
                                        <input type="number" class="form-control quantite-input" name="quantites[]" step="0.01" min="0.01" value="<?php echo htmlspecialchars($ligne['quantite']); ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Prix unitaire (€)</label>
                                        <input type="number" class="form-control prix-input" name="prix[]" step="0.01" min="0.01" value="<?php echo htmlspecialchars($ligne['prix']); ?>" required>
                                    </div>
                                    <div class="col-md-2 mb-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger remove-produit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" id="addProduit">
                        <i class="fas fa-plus me-1"></i>Ajouter un produit
                    </button>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=achats&action=index" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Modifier l'Achat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let produitIndex = <?php echo isset($achat['lignes']) ? count($achat['lignes']) : 0; ?>;

    // Fonction pour créer une nouvelle ligne de produit
    function createProduitRow() {
        const container = document.getElementById('produitsContainer');
        const row = document.createElement('div');
        row.className = 'produit-row border rounded p-3 mb-3';
        row.innerHTML = `
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="form-label">Produit</label>
                    <select class="form-select produit-select" name="produits[]" required>
                        <option value="">Choisir un produit</option>
                        <?php foreach ($produits as $produit): ?>
                        <option value="<?php echo $produit['id']; ?>"><?php echo htmlspecialchars($produit['nom']); ?> (<?php echo htmlspecialchars($produit['categorie_nom']); ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Quantité</label>
                    <input type="number" class="form-control quantite-input" name="quantites[]" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Prix unitaire (€)</label>
                    <input type="number" class="form-control prix-input" name="prix[]" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-produit">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(row);
        updateRemoveButtons();
        produitIndex++;
    }

    // Fonction pour mettre à jour l'affichage des boutons de suppression
    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.produit-row');
        const removeButtons = document.querySelectorAll('.remove-produit');

        if (rows.length > 1) {
            removeButtons.forEach(button => button.style.display = 'block');
        } else {
            removeButtons.forEach(button => button.style.display = 'none');
        }
    }

    // Ajouter un produit
    document.getElementById('addProduit').addEventListener('click', createProduitRow);

    // Supprimer un produit
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-produit') || e.target.closest('.remove-produit')) {
            const row = e.target.closest('.produit-row');
            if (document.querySelectorAll('.produit-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });

    // Initialiser l'état des boutons
    updateRemoveButtons();
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
?>
