<?php
// Connexion à la base de données
try {
    $db_connect = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'ID du billet est présent
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Préparation de la requête de suppression
        $request = $db_connect->prepare("DELETE FROM post WHERE id = :id");

        // Liaison des paramètres
        $request->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécution de la requête
        $request->execute();

        // Redirection vers la page principale
        header("Location: ../index.php");
    } else {
        echo 'ID de billet manquant';
        exit;
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}
