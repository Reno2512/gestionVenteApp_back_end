<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_POST) {
    include 'config/database.php';

    try {
        // Mise à jour de la requête SQL
        $query = "UPDATE ventes SET v_article=:article, v_reference=:reference, v_ligneDetails=:ligneDetails, v_prixUnitaire=:prixUnitaire, v_quantité=:quantité WHERE v_id=:id";
        header("Content-type: application/json; charset=utf-8");

        // Préparation de la requête pour l'exécution
        $stmt = $con->prepare($query);

        // Assignation des valeurs des paramètres
        $id = $_POST['id'];
        $article = $_POST['v_article'];
        $reference = $_POST['v_reference'];
        $ligneDetails = $_POST['v_ligneDetails'];
        $prixUnitaire = $_POST['v_prixUnitaire'];
        $quantité = $_POST['v_quantité'];

        // Liaison des paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':article', $article);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':ligneDetails', $ligneDetails);
        $stmt->bindParam(':prixUnitaire', $prixUnitaire);
        $stmt->bindParam(':quantité', $quantité);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Réponse en cas de succès
            echo json_encode(["message" => "Vente mise à jour avec succès."]);
        } else {
            // Réponse en cas d'échec
            echo json_encode(["message" => "Impossible de mettre à jour la vente."]);
        }
    } catch (PDOException $exception) {
        // Gestion des erreurs
        echo json_encode(["error" => $exception->getMessage()]);
    }
} else {
    echo json_encode(["message" => "Aucune donnée reçue."]);
}

?>
