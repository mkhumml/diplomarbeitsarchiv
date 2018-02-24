<?php
$servername = "localhost"; //MySQL Daten
$user = "root";
$pw = "root";
$db = "diplomarbeit";

$conn = new mysqli($servername, $user, $pw, $db); // Erstelle Verbindung zu MySQL
if ($conn->connect_error) { //Prüft ob Verbindung hergestellt werden konnte, alles != 0 ist true
die("Verbindung fehlgeschlagen: " . $conn->connect_error); //Falls nicht  wird  die aufgerufen, sowas wie exit
}
else {
    echo("erfolgreich");
}
?>