<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require './FunktionsKlasse.php';
require './dbconnect.php';
session_start();
//Read from Json
/*   $string = file_get_contents('./blub.txt');
   $json_a = json_decode($string, true);
   echo $json_a["Price"]["Amount"];
*/
//isset gibt true zurück wenn variable deklariert und nicht null
// Wenn Button gedrückt wird, wird die Variable register gesetzt und somit ergibt die if verzweigung true
#$str2 = filter_input(INPUT_POST, "successLogin");
#echo $str2;
#$str2 = file_get_contents('http://localhost/diplomarbeitsarchiv/Php/index_me.php');
#$json2 = json_decode($str2,true);

#echo $json2;
#echo $json2["password"];

$password = filter_input(INPUT_POST, "firstName"); #$json2["password"];
$email = filter_input(INPUT_POST, "lastName"); #$json2["email"];

echo $email . " HALLO " . $password;

die();

if ((FunktionsKlasse::checkEmail($email))) { //Checkt EMAIL FORMAT
    $passwort = FunktionsKlasse::hashpw($passwort); // Hashen zum sicheren abspeichern mit sha512
    $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND passwort ='" . $passwort . "'"; //SQL Statement zum suchen aller Einträge die mit der eingegebenen email übereinstimmen
    $res = $conn->query($sql);
    if ($res->num_rows > 0) { // Wenn Die Anzahl der rows größer als 0 ist, gibt es ein Eintrag in der DB und somit login :)
        $_SESSION["login"] = 1; // Session Variable login wird auf 1 gesetzt wenn user erfolgreich eingeloggt sonst ist sie 0
        $dbEintrag = $res->fetch_assoc(); // Über fetch->assoc erhalten wir ein assoziatives array
        $_SESSION["name"] = $dbEintrag["vorname"]; // Aus dem Assoziativen Array holen wir uns den vornamen und setzen die Session variable name auf den namen des Users der sich eingeloggt hat

    } else {
        echo "Der Account mit dieser EMail/Passwort Kombination existiert nicht.";
    }
} else {
    die('Ungültiges EMail-Format <a href="login.php">Login</a>');
}
$str = file_get_contents("http://localhost:80/diplomarbeitsarchiv/Php/index.php"); // FILES AUS NEM JSON STRING AUSLESEN
echo $json;
$json = json_decode($str, true);
echo $json;
echo $json["email"];
echo $json["password"];
?>







<?php
if ($_SESSION["login"] != 1) {  //Wenn Session Variable login ungleich 1, also user nicht eingeloggt, dann wird anmeldeformular angezeigt

    require '../src/Login.vue'; //login.html muss vorhanden sein sonst abbruch des scripts

} else {
    echo "Willkommen " . $_SESSION["name"];
    echo '<br>';
    echo 'Login erfolgreich. Weiter zu <a href="erfolgreichEingeloggt.php">internen Bereich</a>';
}
?>
