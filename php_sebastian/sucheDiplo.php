<?php


session_start(); 


if($_SESSION["login"]!=1){ // Wenn Kein User eingeloggt, breche Script ab
    die('Bitte zuerst einloggen <a href="login.php">Login</a>');
}


include './dbconnect.php';
include './FunktionsKlasse.php';




/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




?>


<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <form action="login.php" method="post">
          Klassenvorstand <input type="text" name="klassenvorstand" maxlength="255">  <br>
          Schüler - Nachname<input type="text" name="schueler" maxlength="255" > <br>
          Professor <input type="text" name="professor" maxlength="255" ><br>
          Schlagwort <input type="text" name="schlagwort" maxlength="255" ><br>
          Titel <input type="text" name="titel" maxlength="255" ><br>
          
          
            <input type="submit" value="Login" name="login">   
        </form>
             
  
        <a href="ausgabe.php">Ausgabe</a>
         <a href="upload.php">Upload</a>
         <a href="logout.php">Logout</a>
      
    </body>
</html>

