<?php

session_start();
$_SESSION["login"] = 0;

?>


<?php
//  $str = file_get_contents('./blub.txt'); // FILES AUS NEM JSON STRING AUSLESEN
//   $json = json_decode($str, true);
//    echo '<pre>' . print_r($json, true) . '</pre>';

//   echo $json["Title"];
phpinfo();
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
    <title>Diplomarbeit</title>
</head>
<body>


<a href="login.html">Login</a>
<a href="register.php">Registrieren</a>


</body>
</html>
