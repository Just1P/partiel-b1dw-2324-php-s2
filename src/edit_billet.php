<?php
// Inclusion du header
require_once 'parts/header.php';

// Connexion à la base de données
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des informations du billet à modifier
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $request = $db_connect->prepare("SELECT * FROM post WHERE id = :id");
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->execute();
        $post = $request->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            echo 'Billet non trouvé';
            exit;
        }
    } else {
        echo 'ID de billet manquant';
        exit;
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
?>

<h1>Modifier le billet</h1>
<form action="scripts/update_billet.php" method="post">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie" required>
        <option value="Hommes" <?php if ($post['categorie'] == 'Hommes') echo 'selected'; ?>>Hommes</option>
        <option value="Femmes" <?php if ($post['categorie'] == 'Femmes') echo 'selected'; ?>>Femmes</option>
    </select>
    <br>
    <label for="groupe">Groupe :</label>
    <input type="text" id="groupe" name="groupe" value="<?php echo htmlspecialchars($post['groupe']); ?>" required>
    <br>
    <label for="equipe1">Équipe 1 :</label>
    <input type="text" id="equipe1" name="equipe1" value="<?php echo htmlspecialchars($post['equipe1']); ?>" required>
    <br>
    <label for="equipe2">Équipe 2 :</label>
    <input type="text" id="equipe2" name="equipe2" value="<?php echo htmlspecialchars($post['equipe2']); ?>" required>
    <br>
    <label for="date_heure">Date et Heure :</label>
    <input type="datetime-local" id="date_heure" name="date_heure" value="<?php echo htmlspecialchars($post['date_heure']); ?>" required>
    <br>
    <label for="lieu">Lieu :</label>
    <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($post['lieu']); ?>" required>
    <br>
    <label for="prix">Prix :</label>
    <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($post['prix']); ?>" required>
    <br>
    <label for="description">Description :</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($post['description']); ?></textarea>
    <br>
    <button type="submit">Modifier</button>
</form>

<?php
// Inclusion du footer
require_once 'parts/footer.php';
?>
