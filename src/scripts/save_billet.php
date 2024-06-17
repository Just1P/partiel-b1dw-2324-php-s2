<?php
// Connexion à la base de données
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $request = $db_connect->prepare("INSERT INTO post (categorie, groupe, equipe1, equipe2, date_heure, lieu, prix, description) VALUES (:categorie, :groupe, :equipe1, :equipe2, :date_heure, :lieu, :prix, :description)");

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
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
