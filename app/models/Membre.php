<?php
// Modèle pour les membres

class Membre extends Model {

    // Récupérer tous les membres
    public function getAll() {
        return $this->selectAll('membres', 'nom');
    }

    // Ajouter un nouveau membre
    public function ajouter($nom) {
        return $this->insert('membres', ['nom' => $nom]);
    }

    // Modifier un membre
    public function modifier($id, $nom) {
        $this->update('membres', $id, ['nom' => $nom]);
    }

    // Supprimer un membre
    public function supprimer($id) {
        $this->delete('membres', $id);
    }
}
?>
