<?php

require './dbconnect.php';
require './FunktionsKlasse.php';
?>
<?php

if (isset($_POST["register"])) {


    $errorv = false;  //Errorvariable wird bei Fehler gesetzt

    $vorname = $_POST["vorname"];  //Daten aus Form auslesen
    $nachname = $_POST["nachname"];
    $email = $_POST["email"];
    $passwort = $_POST["password"];
    $passwort2 = $_POST["password2"];
    $gebdat = $_POST["gebdat"];
    if (FunktionsKlasse::checkEmail($email) && FunktionsKlasse::checkForeAndSurename($vorname)
        && FunktionsKlasse::checkForeAndSurename($nachname) && FunktionsKlasse::checkPasswordLength($passwort)
        && FunktionsKlasse::checkPasswordLength($passwort2)) { //Prüft  EMAIL/Name/passwort - Format
        $passwort = FunktionsKlasse::hashpw($passwort);
        $passwort2 = FunktionsKlasse::hashpw($passwort2); //Passwörter hashen

        //Variable für Fehler        
        if ($passwort != $passwort2) { //Überprüfe ob Passwörter übereinstimmen
            echo "Die Passwörter müssen übereinstimmen";
            $errorv = true;
        }
        if ($errorv == false) { //Wenn bis dahin kein Fehler überprüfe ob email bereits verwendet wird
            $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
            $res = $conn->query($sql); // Führer SQL Statement aus und speicher ergebnis ( Objekt falls vorhanden in $res )
            if ($res->num_rows > 0) { //Falls Eintrag vorhanden dann wird email bereits verwendet
                echo "EMail wird bereits verwendet";
            } else {
                $insert = "INSERT INTO users(vorname, nachname, email, passwort, gebdat) VALUES ('" . $vorname . "','" . $nachname . "','" . $email . "','" . $passwort . "','" . $gebdat . "')";

                if ($conn->query($insert) == true) {
                    echo "Erfolgreich registriert!";
                } else {
                    echo "Fehler bei Registrierung!";
                }

            }
        }

    } else {
        die('Ungültiges Format <a href="register.php">Register</a>');
    }

}

?>