<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'config/database.php';

    // Activer les erreurs PDO
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Récupérer les données POST
        $data = json_decode(file_get_contents("php://input"), true);

        // Vérifiez si $data est bien un tableau
        if (is_array($data)) {
            // Transformer le tableau d'objets en un objet simple
            $dataObj = new stdClass();
            foreach ($data as $item) {
                if (isset($item['key']) && isset($item['value'])) {
                    $key = $item['key'];
                    $value = $item['value'];
                    $dataObj->$key = $value;
                }
            }

            // Assurez-vous que toutes les données nécessaires sont présentes
            if (!empty($dataObj->v_article) && !empty($dataObj->v_reference) && !empty($dataObj->v_ligneDetails) && 
            !empty($dataObj->v_prixUnitaire) && !empty($dataObj->v_quantite)) {
                
                // Insertion de la requête SQL
                $query = "INSERT INTO ventes (v_article, v_reference, v_ligneDetails, v_prixUnitaire, v_quantite, v_montantTotal) 
                          VALUES (:article, :reference, :ligneDetails, :prixUnitaire, :quantite, :montantTotal)";

                // Préparation de la requête pour l'exécution
                $stmt = $con->prepare($query);

                // Calculer le montant total
                $montantTotal = $dataObj->v_prixUnitaire * $dataObj->v_quantite;

                // Liaison des paramètres
                $stmt->bindParam(':article', $dataObj->v_article);
                $stmt->bindParam(':reference', $dataObj->v_reference);
                $stmt->bindParam(':ligneDetails', $dataObj->v_ligneDetails);
                $stmt->bindParam(':prixUnitaire', $dataObj->v_prixUnitaire);
                $stmt->bindParam(':quantite', $dataObj->v_quantite);
                $stmt->bindParam(':montantTotal', $montantTotal);

                // Exécution de la requête
                if ($stmt->execute()) {
                    // Réponse en cas de succès
                    echo json_encode(["message" => "Vente enregistrée avec succès."]);
                } else {
                    // Réponse en cas d'échec
                    echo json_encode(["message" => "Impossible d'enregistrer la vente."]);
                }
            } else {
                echo json_encode(["message" => "Données incomplètes."]);
            }
        } else {
            echo json_encode(["message" => "Format de données incorrect."]);
        }
    } catch (PDOException $exception) {
        // Gestion des erreurs
        echo json_encode(["error" => $exception->getMessage()]);
    }
} else {
    echo json_encode(["message" => "Aucune donnée reçue."]);
}

?>
