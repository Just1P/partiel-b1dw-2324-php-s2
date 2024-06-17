<?php
// Inclusion du header
require_once 'parts/header.php';
?>

<h1>Ajouter un nouveau billet</h1>
<form action="scripts/save_billet.php" method="post">
    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie" required>
        <option value="Hommes">Hommes</option>
        <option value="Femmes">Femmes</option>
    </select>
    <br>
    <label for="groupe">Groupe :</label>
    <input type="text" id="groupe" name="groupe" required>
    <br>
    <label for="equipe1">Équipe 1 :</label>
    <input type="text" id="equipe1" name="equipe1" required>
    <br>
    <label for="equipe2">Équipe 2 :</label>
    <input type="text" id="equipe2" name="equipe2" required>
    <br>
    <label for="date_heure">Date et Heure :</label>
    <input type="datetime-local" id="date_heure" name="date_heure" required>
    <br>
    <label for="lieu">Lieu :</label>
    <input type="text" id="lieu" name="lieu" required>
    <br>
    <label for="prix">Prix :</label>
    <input type="number" id="prix" name="prix" required>
    <br>
    <label for="description">Description :</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <button type="submit">Ajouter</button>
</form>

<?php
require_once 'parts/footer.php';
?>
