<?php
require_once 'parts/header.php';
?>

<h1>Ajouter un nouveau billet</h1>
<div class="form-container">
    <form action="scripts/save_billet.php" method="post" class="styled-form">
        <div class="form-group">
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <option value="Hommes">Hommes</option>
                <option value="Femmes">Femmes</option>
            </select>
        </div>
        <div class="form-group">
            <label for="groupe">Groupe :</label>
            <input type="text" id="groupe" name="groupe" required>
        </div>
        <div class="form-group">
            <label for="equipe1">Équipe 1 :</label>
            <input type="text" id="equipe1" name="equipe1" required>
        </div>
        <div class="form-group">
            <label for="equipe2">Équipe 2 :</label>
            <input type="text" id="equipe2" name="equipe2" required>
        </div>
        <div class="form-group">
            <label for="date_heure">Date et Heure :</label>
            <input type="datetime-local" id="date_heure" name="date_heure" required>
        </div>
        <div class="form-group">
            <label for="lieu">Lieu :</label>
            <input type="text" id="lieu" name="lieu" required>
        </div>
        <div class="form-group">
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" required>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>

<?php
require_once 'parts/footer.php';
?>
