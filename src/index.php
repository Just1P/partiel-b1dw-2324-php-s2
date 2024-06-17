<?php
// Inclusion du header
require_once 'parts/header.php';

// Connexion à la base de données
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier l'ordre de tri sélectionné
    $order = 'ASC';
    if (isset($_GET['order']) && $_GET['order'] == 'DESC') {
        $order = 'DESC';
    }

    // Récupération des posts avec tri par prix
    $request = $db_connect->query("SELECT * FROM post ORDER BY prix $order");
    $posts = $request->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
?>

<h1>Liste des Posts</h1>

<!-- Formulaire de filtre -->
<form method="get" action="index.php">
    <label for="order">Trier par prix :</label>
    <select id="order" name="order">
        <option value="ASC" <?php if ($order == 'ASC') echo 'selected'; ?>>Croissant</option>
        <option value="DESC" <?php if ($order == 'DESC') echo 'selected'; ?>>Décroissant</option>
    </select>
    <button type="submit">Appliquer</button>
</form>

<a href="add-billet.php" class="btn btn-primary">Ajouter un nouveau billet</a>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="billet">
            <div class="main-content">
                <div class="title">
                    <?php echo htmlspecialchars($post['categorie']); ?>
                </div>
                <div class="infos">
                    <?php echo htmlspecialchars($post['groupe']); ?> - <?php echo htmlspecialchars($post['equipe1']); ?> vs <?php echo htmlspecialchars($post['equipe2']); ?> : <?php echo isset($post['description']) ? htmlspecialchars($post['description']) : ''; ?>
                </div>
                <div class="date_heure">
                    <?php echo htmlspecialchars($post['date_heure']); ?> | <?php echo htmlspecialchars($post['lieu']); ?>
                </div>
            </div>
            <div class="price">
                <?php echo htmlspecialchars($post['prix']); ?> €
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun post trouvé</p>
<?php endif; ?>

<?php
// Inclusion du footer
require_once 'parts/footer.php';
?>
