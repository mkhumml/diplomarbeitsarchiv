     <?php 
       
      require './dbconnect.php';
     
  ?>


<!DOCTYPE html> 
<html> 
<head>
  <title>Passwort zurücksetzen</title> 
  
  
   <?php
if (isset($_POST['reset'])){   

    $error = false;
    $email = $_POST["email"];
    
    if(FunktionsKlasse::checkEmail($email)){
    
    $from = "From: sebastian.kielbasa@studierende.htl-donaustadt.at";
    $sql = "SELECT * FROM users where email ='".$email."'";

    $res = $conn->query($sql);
    if($res->num_rows > 0 ){
       
        $passwort = substr(md5(uniqid(rand(),1)),3,10); // Geniere ein neues 10 Zeichen langes Passwort
        $pass = hash("sha512",$passwort); // Verhashtes Passwort für Datenbank
        mail($email,"Passwort Reset","Ihr neues Passwort lautet : ".$passwort,$from); // Problem hier, mails kommen nicht an
        $sql = "UPDATE users SET passwort ='".$pass."' WHERE email='".$email."'";
         if($conn->query($sql)){
             echo "Passwort erfolgreich zurückgesetzt";
         }
     
        
    }else{
        echo "Ein Account mit dieser EMail existiert nicht";
        $error = true;
    }

}else{
    die('Ungültiges EMail-Format <a href="reset_password.php">Reset Password</a>');
}

}
 ?>
  
</head> 
<body>

    <form action="reset_password.php" method="post">
        EMail <input type="email" name="email" maxlength="255" required><br>
        <input type="submit" name="reset">
        
    </form>
    
</body>
</html>