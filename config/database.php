<?php
// Pour la connexion à la base de données

$host = "localhost";
$db_name = "gestionVenteJournaliere";
$username = "root";
$password = "root";
$port = 8889;
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock"; // Chemin vers le socket

try {
    $con = new PDO("mysql:host=$host;port=$port;dbname=$db_name;unix_socket=$socket", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Erreur de connection : " . $exception->getMessage();
}
?>
