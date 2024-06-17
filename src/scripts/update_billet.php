<?php
// Connexion à la base de données
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'ID du billet est présent
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Préparation de la requête de mise à jour
        $request = $db_connect->prepare("UPDATE post SET categorie = :categorie, groupe = :groupe, equipe1 = :equipe1, equipe2 = :equipe2, date_heure = :date_heure, lieu = :lieu, prix = :prix, description = :description WHERE id = :id");

        $request->bindParam(':id', $id, PDO::PARAM_INT);
        $request->bindParam(':categorie', $_POST['categorie']);
        $request->bindParam(':groupe', $_POST['groupe']);
        $request->bindParam(':equipe1', $_POST['equipe1']);
        $request->bindParam(':equipe2', $_POST['equipe2']);
        $request->bindParam(':date_heure', $_POST['date_heure']);
        $request->bindParam(':lieu', $_POST['lieu']);
        $request->bindParam(':prix', $_POST['prix']);
        $request->bindParam(':description', $_POST['description']);

        $request->execute();

        header("Location: ../index.php");
    } else {
        echo 'ID de billet manquant';
        exit;
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
