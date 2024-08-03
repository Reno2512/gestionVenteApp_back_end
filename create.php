<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-type: application/json; charset=utf-8");

if ($_POST) {
    include 'config/database.php';

    // Activer les erreurs PDO
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    try {

        // Affichez les données POST pour le débogage
        var_dump($_POST);
        
        // Insertion de la requête SQL
        $query = "INSERT INTO ventes (v_article, v_reference, v_ligneDetails, v_prixUnitaire, v_quantite) 
                  VALUES (:article, :ligneDetails, :prixUnitaire, :quantite)";

        // Préparation de la requête pour l'exécution
        $stmt = $con->prepare($query);

        // Assignation des valeurs des paramètres
        $article = $_POST['v_article'];
        $reference = $_POST['v_reference'];
        $ligneDetails = $_POST['v_ligneDetails'];
        $prixUnitaire = $_POST['v_prixUnitaire'];
        $quantite = $_POST['v_quantite'];


        

        // Liaison des paramètres
        $stmt->bindParam(':article', $article);
        $stmt->bindParam(':reference', $reference);      
        $stmt->bindParam(':ligneDetails', $ligneDetails);
        $stmt->bindParam(':prixUnitaire', $prixUnitaire);
        $stmt->bindParam(':quantite', $quantite);

        // Affichez le nombre de colonnes liées pour débogage
        echo "Nombre de paramètres liés : " . $stmt->columnCount() . "\n";


        // Exécution de la requête
        if ($stmt->execute()) {
            // Réponse en cas de succès
            echo json_encode(["message" => "Vente enregistrer avec succès."]);
        } else {
            // Réponse en cas d'échec
            echo json_encode(["message" => "Impossible d'enregistrer la vente."]);
        }
    } catch (PDOException $exception) {
        // Gestion des erreurs
        echo json_encode(["error" => $exception->getMessage()]);
    }
} else {
    echo json_encode(["message" => "Aucune donnée reçue."]);
}

?>
