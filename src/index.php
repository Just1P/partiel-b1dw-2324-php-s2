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

    // Obtenir les valeurs min et max du prix des billets actuels
    $priceRange = $db_connect->query("SELECT MIN(prix) as min_price, MAX(prix) as max_price FROM post")->fetch(PDO::FETCH_ASSOC);
    $minPrice = $priceRange['min_price'];
    $maxPrice = $priceRange['max_price'];

    // Filtrage par fourchette de prix
    $minSelectedPrice = isset($_GET['min_price']) ? $_GET['min_price'] : $minPrice;
    $maxSelectedPrice = isset($_GET['max_price']) ? $_GET['max_price'] : $maxPrice;

    // Filtrage par catégorie
    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

    // Filtrage par groupe
    $selectedGroup = isset($_GET['groupe']) ? $_GET['groupe'] : '';

    // Filtrage par lieu
$selectedLocation = isset($_GET['lieu']) ? $_GET['lieu'] : '';


    // Construction de la requête SQL avec les filtres
    $sql = "SELECT * FROM post WHERE prix BETWEEN :min_price AND :max_price";
    if (!empty($selectedCategory)) {
        $sql .= " AND categorie = :category";
    }
    if (!empty($selectedGroup)) {
        $sql .= " AND groupe = :groupe";
    }
    if (!empty($selectedLocation)) {
        $sql .= " AND lieu = :lieu";
    }
    
    $sql .= " ORDER BY prix $order";

    $request = $db_connect->prepare($sql);
    $request->bindParam(':min_price', $minSelectedPrice, PDO::PARAM_INT);
    $request->bindParam(':max_price', $maxSelectedPrice, PDO::PARAM_INT);
    if (!empty($selectedCategory)) {
        $request->bindParam(':category', $selectedCategory, PDO::PARAM_STR);
    }
    if (!empty($selectedGroup)) {
        $request->bindParam(':groupe', $selectedGroup, PDO::PARAM_STR);
    }
    if (!empty($selectedLocation)) {
        $request->bindParam(':lieu', $selectedLocation, PDO::PARAM_STR);
    }
    
    $request->execute();
    $posts = $request->fetchAll(PDO::FETCH_ASSOC);

    // Obtenir les catégories uniques
    $categories = $db_connect->query("SELECT DISTINCT categorie FROM post")->fetchAll(PDO::FETCH_ASSOC);

    // Obtenir les groupes uniques
    $groups = $db_connect->query("SELECT DISTINCT groupe FROM post")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}

    // Obtenir les lieux uniques
    $locations = $db_connect->query("SELECT DISTINCT lieu FROM post")->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Liste des Posts</h1>

    <div class="filter-container">
        <form method="get" action="index.php" class="filter-form">
            <div class="filter-group">
                <select id="lieu" name="lieu">
                    <option value="">Sélectionner un lieu</option>
                    <?php foreach ($locations as $location): ?>
                        <option value="<?php echo ($location['lieu']); ?>" <?php if ($selectedLocation == $location['lieu']) echo 'selected'; ?>>
                            <?php echo ($location['lieu']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <select id="category" name="category">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo ($category['categorie']); ?>" <?php if ($selectedCategory == $category['categorie']) echo 'selected'; ?>>
                            <?php echo ($category['categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <select id="order" name="order">
                    <option value="ASC" <?php if ($order == 'ASC') echo 'selected'; ?>>Croissant</option>
                    <option value="DESC" <?php if ($order == 'DESC') echo 'selected'; ?>>Décroissant</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="min_price">Prix minimum : <span id="min_price_value"><?php echo ($minSelectedPrice); ?></span> €</label>
                <input type="range" id="min_price" name="min_price" value="<?php echo ($minSelectedPrice); ?>" min="<?php echo ($minPrice); ?>" max="<?php echo ($maxPrice); ?>" oninput="document.getElementById('min_price_value').innerText = this.value;">
            </div>

            <div class="filter-group">
                <label for="max_price">Prix maximum : <span id="max_price_value"><?php echo ($maxSelectedPrice); ?></span> €</label>
                <input type="range" id="max_price" name="max_price" value="<?php echo ($maxSelectedPrice); ?>" min="<?php echo ($minPrice); ?>" max="<?php echo ($maxPrice); ?>" oninput="document.getElementById('max_price_value').innerText = this.value;">
            </div>

            <div class="filter-group">
                <label for="groupe">Groupe :</label>
                <select id="groupe" name="groupe">
                    <option value="">Tous les groupes</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?php echo ($group['groupe']); ?>" <?php if ($selectedGroup == $group['groupe']) echo 'selected'; ?>>
                            <?php echo ($group['groupe']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group buttons">
                <button type="submit">Appliquer</button>
                <button type="button" onclick="window.location.href='index.php';">Réinitialiser</button>
            </div>
        </form>
        <a href="add_billet.php" class="btn btn-primary">Ajouter un nouveau billet</a>
    </div>

    

    <div class="posts-container">
    
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <div class="post-header">
                        <h2><?php echo ($post['categorie']); ?></h2>
                    </div>
                    <div class="post-body">
                        <p><?php echo ($post['groupe']); ?> - <?php echo ($post['equipe1']); ?> vs <?php echo ($post['equipe2']); ?></p>
                        <p><?php echo isset($post['description']) ?  ($post['description']) : ''; ?></p>
                        <p><?php echo ($post['date_heure']); ?> | <?php echo ($post['lieu']); ?></p>
                        <p>Prix : <?php echo ($post['prix']); ?> €</p>
                    </div>
                    <div class="post-actions">
                        <a href="edit_billet.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Modifier</a>
                        <form action="scripts/delete_billet.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce billet ?');">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun post trouvé</p>
        <?php endif; ?>
    </div>


<?php
require_once 'parts/footer.php';
?>
