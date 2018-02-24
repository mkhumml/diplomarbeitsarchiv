<?php

session_start(); 
if($_SESSION["login"]!=1){ // Wenn Kein User eingeloggt, breche Script ab
    die('Bitte zuerst einloggen <a href="login.php">Login</a>');
}
include './dbconnect.php';
include './FunktionsKlasse.php';
$sql = "SELECT * FROM diplomarbeiten";
$res = $conn->query($sql);



while($row = mysqli_fetch_array($res)){ //Geht silange durch bis kein Eintrag mehr gefunden
    $id = $row["ID"];
    $s1 = $row["Schuler1"];
    $s2 = $row["Schuler2"]; 
    $s3 = $row["Schuler3"];
    $s4 = $row["Schuler4"];
    $s5 = $row["Schuler5"];
    $p1 = $row["Professor1"];
    $p2 = $row["Professor2"];
    $titel= $row["Titel"];
    $abteilung = $row["Abteilung"];
    $klasse = $row["Klasse"];
    $kv = $row["Klassenvorstand"];
    $jg = $row["Jahrgang"];
    $schlagw = $row["Schlagwort"];    
    $diplo = $row["Diplomarbeit"];
    $pfad_diplo = './uploads/'.$titel.'.'.$s1.'/'.$diplo.'';
    $zusatz = $row["Zusatz"];
    $pfad_zusatz = './uploads/'.$titel.'.'.$s1.'/'.$zusatz.'';
    
    if(!isset($_GET["dwnd"])){
  echo $id." ".$s1." ".$s2." ".$s3." ".$s4." ".$s5." ".$p1." ".$p2." ".$titel." ".$abteilung." ".$klasse." ".$kv." ".$jg." ".$schlagw." "."<a href='$pfad_diplo'>" .$diplo. "</a> " . " <a href='$pfad_zusatz'>" ." ".$zusatz. "</a> " . "<a href='ausgabe.php?id=$id'> Delete</a> " . "    " ." <a href='ausgabe.php?dwnd=$id'> Download </a> <br>";   
    }
}

if(isset($_GET["id"]))  { //Assoziatives Array, löscht Eintrag mit der id,   
    $idd = $_GET["id"];
    $sql = "DELETE FROM diplomarbeiten WHERE ID = '$idd'";
    $sql_2 = "SELECT * FROM diplomarbeiten WHERE ID = '$idd'";
    
     if(($res = $conn->query($sql_2))==true){ //Datensatz wird ausgefwählt
         $row = mysqli_fetch_array($res);   
         $titel = $row["Titel"];
         $s1 = $row["Schuler1"]; //Titel und Schueler1 wird benötigt um Ordner zu löschen
         
         $files = glob('./uploads/'.$titel.'.'.$s1.'/*'); // get all file names, bevor ordner gelöscht werden kann muss er leer sein
            foreach($files as $file){ // iterate durch files
                 if(is_file($file))
                  unlink($file); // lösche file
                }      
         rmdir('./uploads/'.$titel.'.'.$s1.'/.');  //Ordner wird gelöscht, er muss jedoch leer sein
         $conn->query($sql); //Datensatz wird aus der Datenbank gelöscht
         header('Location: ausgabe.php'); // Umleitung
         
     }     
} 


if(isset($_GET["dwnd"])){ //Schaut ob download angeklickt wurde, wenn ja dann wird rekursiv durch den Ordner gegangen
                         //Und alle Dateien werden in eine Zip Datei gepackt und dann runtergeladet     
    $id_d = $_GET["dwnd"];
    $sql_2 = "SELECT * FROM diplomarbeiten WHERE ID = '$id_d'";  
    $result = $conn->query($sql_2);     
        $row = mysqli_fetch_array($result);        
        $titel = $row["Titel"];
        $s1 = $row["Schuler1"];
        $diplo = $row["Diplomarbeit"];  
        $zusatz = $row["Zusatz"];              
        $rootPath = realpath('./uploads/'.$titel.'.'.$s1.'/');  //Absoluter Pfad zu den Dateien
        $zip = new ZipArchive(); //Neues Zip Objekt
        $zip->open('./uploads/'.$titel.'.'.$s1.'/file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE); //Öffnet/Erstellt zip file, falls vorhanden wird zip überschrieben
        $files = new RecursiveIteratorIterator(  
         new RecursiveDirectoryIterator($rootPath),
             RecursiveIteratorIterator::LEAVES_ONLY); //Erstellt Rekursiven Iterator     
        foreach ($files as $name => $file) 
         {

        if (!$file->isDir() && ($file->getFilename()!="file.zip")) //Nur wenn kein Ordner dann, (Ordner werden eh automatisch eingefügt)
        //Geht durch Ordner Rekursiv durch und fügt Dateien in ein Zip File Ein, exkluded file.zip 
        //wenn Filename = file.zip dann wird es nicht in die file.zip eingefügt !! deswegen getFilename
          {
        $filePath = $file->getRealPath(); // Gibt Absoluten/Realen Pfad der Datei
        $relativePath = substr($filePath, strlen($rootPath) + 1); //Relativer Pfad zur datei mithilfe von substr
        $zip->addFile($filePath, $relativePath); //File ins Zip einfügen
       }
}
    $zip->close(); //Schließe Zip  
    header("Content-type:application/zip");    
    header('Content-Disposition: attachment; filename=./uploads/'.$titel.'.'.$s1.'/file.zip');
    readfile( './uploads/'.$titel.'.'.$s1.'/file.zip');
    $_GET["dwnd"]=null; //Setzt dwnd null damit nach dem Download wieder Diplomarbeiten ausgegeben werden
    die();       
}
   


?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <br>  <a href ="logout.php">Logout</a>
         <a href ="upload.php"> Upload</a>
       <a href="sucheDiplo.php">Suche</a>
        
    </body>
</html>