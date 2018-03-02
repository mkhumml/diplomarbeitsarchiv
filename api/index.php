<?php
require 'flight/Flight.php';
$servername = "localhost"; //MySQL Daten
$user = "root";
$pw = "root";
$db = "diplomarbeitsarchiv";

Flight::route('GET /diplomarbeiten', function () {
    $authors[] = array('id' => "3", 'firstname' => 'Stefan', 'lastname' => 'Matl');
    $authors[] = array('id' => "4", 'firstname' => 'Paul', 'lastname' => 'Ortner');
    $departments[] = array('id' => "1", 'name' => 'Informationstechnologie');
    $departments[] = array('id' => "2", 'name' => 'Elektronik');
    $departments[] = array('id' => "3", 'name' => 'Fachschule');
    $tutors[] = array('id' => "1", 'firstname' => 'Erik', 'lastname' => 'Sacher');
    $tutors[] = array('id' => "2", 'firstname' => 'Bernhard', 'lastname' => 'Loibner');
    $diploma[] = array('id' => 1, 'title' => "title1", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => "summary1", 'attachments' => "attachments1", 'tags' => "tags1");
    $diploma[] = array('id' => 2, 'title' => "title2", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr2", 'upload' => "diplomathesispdf2", 'summary' => "summary2", 'attachments' => "attachments2", 'tags' => "tags2");
    $diploma[] = array('id' => 3, 'title' => "title3", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr3", 'upload' => "diplomathesispdf3", 'summary' => "summary3", 'attachments' => "attachments3", 'tags' => "tags3");
    $diploma[] = array('id' => 4, 'title' => "title4", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr4", 'upload' => "diplomathesispdf4", 'summary' => "summary4", 'attachments' => "attachments4", 'tags' => "tags4");
    $diploma[] = array('id' => 5, 'title' => "title5", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr5", 'upload' => "diplomathesispdf5", 'summary' => "summary5", 'attachments' => "attachments5", 'tags' => "tags5");
    $diploma[] = array('id' => 6, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => "summary6", 'attachments' => "attachments6", 'tags' => "tags6");
    echo json_encode($diploma);
});

Flight::route('GET /users', function () {
    $users[] = array('id' => "2", 'email' => 'stefan', 'password' => 'stefan');
    $users[] = array('id' => "1", 'email' => 'markus', 'password' => 'markus');
    $users[] = array('id' => "3", 'email' => 'sebi', 'password' => 'sebi');
    $users[] = array('id' => "4", 'email' => 'paul', 'password' => 'paul');
    echo json_encode($users);
});

Flight::route('GET /authors', function () {
    $authors[] = array('id' => "1", 'firstname' => 'Markus', 'lastname' => 'Humml');
    $authors[] = array('id' => "2", 'firstname' => 'Karl', 'lastname' => 'Heinz');
    $authors[] = array('id' => "3", 'firstname' => 'Stefan', 'lastname' => 'Matl');
    $authors[] = array('id' => "4", 'firstname' => 'Paul', 'lastname' => 'Ortner');
    echo json_encode($authors);
});

Flight::route('GET /tutors', function () {
    $tutors[] = array('id' => "1", 'firstname' => 'Erik', 'lastname' => 'Sacher');
    $tutors[] = array('id' => "2", 'firstname' => 'Bernhard', 'lastname' => 'Loibner');
    echo json_encode($tutors);
});

Flight::route('GET /departments', function () {
    $departments[] = array('id' => "1", 'name' => 'Informationstechnologie');
    $departments[] = array('id' => "2", 'name' => 'Elektronik');
    $departments[] = array('id' => "3", 'name' => 'Fachschule');
    echo json_encode($departments);
});


Flight::route('GET /diplomarbeiten/@id', function ($id) {
    $arr1 = array('id' => $id, 'title' => "title1", 'author' => "author1", 'tutor' => "tutor1", 'departments' => "department1", 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => "summary1", 'attachments' => "attachments1", 'tags' => "tags1");
    echo json_encode($arr1);
});

Flight::route('DELETE /diplomarbeiten/@id', function ($id) {
    echo "$id";
});

// Create or update diploma
Flight::route('POST /diplomarbeiten', function () {
    $json = file_get_contents("php://input");
    $diploma = json_decode($json, true);

    /*
        if($dimploma["id"] === null) {
            // Create new diploma in db
        } else {
            // Update diploma with id in db
        }
        // Get created/updated diploma from db
        // Return created/updated diploma as JSON to client
    */

    $diploma["title"] = "qwertzuiopü";
    $diploma["author"] = "authorssss";
    echo json_encode($diploma);
});


Flight::route('POST /authors', function () {
    $json = file_get_contents("php://input");
    $authors = json_decode($json, true);
    $authors[0]["firstname"] = "fAuthorFromServer";
    $authors[0]["lastname"] = "lAuthorFromServer";
    echo json_encode($authors);
});

Flight::route('POST /tutors', function () {
    $json = file_get_contents("php://input");
    $tutors = json_decode($json, true);
    $tutors[0]["firstname"] = "fTutorFromServer";
    $tutors[0]["lastname"] = "lTutorFromServer";
    echo json_encode($tutors);
});

Flight::route('POST /departments', function () {
    $json = file_get_contents("php://input");
    $departments = json_decode($json, true);
    $departments[0]["name"] = "DepartmentFromServer";
    echo json_encode($departments);
});

/*
Flight::route('POST /login', function () {
    $json = file_get_contents("php://input");
    $users = json_decode($json, true);

        $password = hash("sha512",$users["password"] );
        $email = $users["email"];

        $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND passwort ='" . $password . "'"; //SQL Statement zum suchen aller Einträge die mit der eingegebenen email übereinstimmen
        $res = $conn->query($sql);
        if ($res->num_rows > 0) { // Wenn Die Anzahl der rows größer als 0 ist, gibt es ein Eintrag in der DB und somit login :)
            $_SESSION["login"] = 1; // Session Variable login wird auf 1 gesetzt wenn user erfolgreich eingeloggt sonst ist sie 0
            echo($_SESSION["login"]);
        } else {
            $_SESSION["login"] = 0;
            echo($_SESSION["login"]);
        }

});
*/

Flight::route('POST /register', function () {
    $errorv = false;  //Errorvariable wird bei Fehler gesetzt

    $json = file_get_contents("php://input");
    $users = json_decode($json, true);
    $email = $users["email"];
    $password = $users["password"];
    //$password2 = $users["password2"];
    $password = hash("sha512", $users["password"]);
    //$password2 = hash("sha512", $users["password2"]);
    echo($password);
    //Variable für Fehler
    /*
    if ($password != $password2) { //Überprüfe ob Passwörter übereinstimmen
        echo "Die Passwörter müssen übereinstimmen";
        $errorv = true;
    }
    if ($errorv == false) { //Wenn bis dahin kein Fehler überprüfe ob email bereits verwendet wird
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $res = $conn->query($sql); // Führer SQL Statement aus und speicher ergebnis ( Objekt falls vorhanden in $res )
        if ($res->num_rows > 0) { //Falls Eintrag vorhanden dann wird email bereits verwendet
            echo "EMail wird bereits verwendet";
        } else {
            $insert = "INSERT INTO users(vorname, nachname, email, password, gebdat) VALUES ('" . $vorname . "','" . $nachname . "','" . $email . "','" . $passwort . "','" . $gebdat . "')";

            if ($conn->query($insert) == true) {
                echo "Erfolgreich registriert!";
            } else {
                echo "Fehler bei Registrierung!";
            }

        }
    }

    */
});

Flight::start();
?>