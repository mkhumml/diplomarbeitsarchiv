<?php
session_start(); 


if($_SESSION["login"]!=1){ // Wenn Kein User eingeloggt, breche Script ab
    die('Bitte zuerst einloggen <a href="login.php">Login</a>');
}


?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        
    </head>
    <body>
           
      <?php 
      echo "Willkommen ".$_SESSION["name"];
      ?>
        
         <a href ="upload.php">Upload</a> 
        <a href ="logout.php">Logout</a><br>
          <a href ="ausgabe.php">Diplomarbeiten</a>
         
         
    </body>
</html>
