<?php
header("Access-control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Inclure le fichier de connexion à la base de données
include 'config/database.php';

header("Content-type: application/json; charset=utf-8");

//afficher toutes les ventes

$query = "SELECT v_id, v_reference, v_montantTotal, v_date FROM ventes ORDER BY v_id DESC";
$stmt = $con -> prepare($query);
$stmt -> execute();
$results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo $json

?>
