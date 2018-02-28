<?php
session_start(); 


if($_SESSION["login"]!=1){ // Wenn Kein User eingeloggt, breche Script ab
    die('Bitte zuerst einloggen <a href="login.php">Login</a>');
}


include './dbconnect.php';
include './FunktionsKlasse.php';




if(isset($_POST["upload"])){
    
    
    //Für Struktur des ass. $_FILES Array siehe http://php.net/manual/de/reserved.variables.files.php
    
    $s1 = $_POST["nachname1"];
    $s2 = $_POST["nachname2"];
    
    if(!(isset($_POST["nachname3"]))){ //Prüft ob die Variablen gesetzt sind, falls nicht dann werden sie null gesetzt
       $s3 = "";
    }else{
        $s3 = $_POST["nachname3"];
    }
    if(!(isset($_POST["nachname4"]))){
       $s4 = "";
    }else{
        $s4 = $_POST["nachname4"];
    }
     if(!(isset($_POST["nachname5"]))){
       $s5 = "";
    }else{
        $s5 = $_POST["nachname5"];
    }
    if(!(isset($_POST["professor2"]))){
       $p2 = "";
    }else{
        $p2 = $_POST["professor2"];
    }   
     if(!(isset($_POST["schlagwort"]))){
       $schlagw = "";
    }else{
        $schlagw = $_POST["schlagwort"];
    }
    
    $p1 = $_POST["professor1"];
    $titel = $_POST["titel"];
    $abteilung = $_POST["abteilung"];
    $klasse = $_POST["klasse"];
    $kv = $_POST["klassenvorstand"];
    $jg = $_POST["jahrgang"];  
    $diplo_name= $_FILES["diplomarbeit"]['name']; 
    $diplo_tmp_name= $_FILES["diplomarbeit"]['tmp_name'];
    $zusatz_name = $_FILES["zusatz"]["name"];
    $zusatz_tmp_name = $_FILES["zusatz"]["tmp_name"];
    
     $path= './uploads/'.$titel.'.'.$s1.'./';
     mkdir('./uploads/'.$titel.'.'.$s1.'.');
 
     $position_zusatz= strpos($zusatz_name, "."); 
     $fileextension_zusatz = substr($zusatz_name, $position_zusatz + 1);
     $fileextension_zusatz = strtolower($fileextension_zusatz);
      move_uploaded_file($zusatz_tmp_name, $path.$zusatz_name);

    
    $position_diplo= strpos($diplo_name, ".");  //Gibt numerische Position des Zeichen . zurück
    $fileextension_diplo = substr($diplo_name, $position_diplo + 1);//Gibt Teil eines Strings zurück   
    $fileextension_diplo = strtolower($fileextension_diplo);       //Zusatz kleinbuchstaben 
     move_uploaded_file($diplo_tmp_name, $path.$diplo_name); //Datei hochladen

$sql = "INSERT INTO diplomarbeiten (Schuler1,Schuler2,Schuler3,Schuler4,Schuler5,Professor1,Professor2,Titel,Abteilung,Klasse,Klassenvorstand,Jahrgang,Diplomarbeit,Zusatz,Schlagwort) values ('".$s1."','".$s2."','".$s3."','".$s4."','".$s5."','".$p1."','".$p2."','".$titel."','".$abteilung."','".$klasse."','".$kv."','".$jg."','" .$diplo_name."','".$zusatz_name."','".$schlagw."')";
  if($conn->query($sql)==true){
       echo "Erfolgreich hochgeladen!";
 }else{
      echo "Fehler beim hochladen!";
    }
}
?>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Schüler 1 <input type="text" name="nachname1" maxlength="255" > <br>
            Schüler 2 <input type="text" name="nachname2" maxlength="255" > <br>
            Schüler 3 <input type="text" name="nachname3" maxlength="255"> <br>
            Schüler 4 <input type="text" name="nachname4" maxlength="255"> <br>
            Schüler 5 <input type="text" name="nachname5" maxlength="255"> <br>
            Professor 1<input type="text" name="professor1" maxlength="255" > <br>
            Professor 2´<input type="text" name="professor2" maxlength="255" ><br>
            Titel <input type="text" name="titel" maxlength="255" ><br>
            Abteilung <input type="text" name="abteilung" maxlength="255" ><br>
            Klasse <input type="text" name="klasse" maxlength="255" ><br>
            Klassenvorstand <input type="text" name="klassenvorstand" maxlength="255" ><br>
            Jahrgang <input type="text" name="jahrgang" maxlength="255" ><br>
            Schlagwort  <input type="text" name="schlagwort" maxlength="255" >  <br>      
            Diplomarbeit <input type="file" name="diplomarbeit"> <br>
            Zusatz <input type="file" name="zusatz" ><br>

            <input type="submit" value="Hochladen" name="upload">  
        </form>
              <a href ="ausgabe.php">Diplomarbeiten</a>
               <a href ="logout.php">Logout</a>
               <a href="sucheDiplo.php">Suche</a> 
      
    </body>
</html>
