<?php
/* TODO?
 * Multiselect Listen in der Datenbank - Prüfen ob der Eintrag noch irgenwo Verwendet wird, wenn nicht in der DB löschen
 */
require 'flight/Flight.php';
/**
 * Get list of diplomas.
 */
Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=diplomarbeitsarchiv', 'root', 'root'), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});


Flight::route('GET /diplomarbeiten', function () {
    $authors[] = array('id' => "3", 'firstname' => 'Stefan', 'lastname' => 'Matl');
    $authors[] = array('id' => "4", 'firstname' => 'Paul', 'lastname' => 'Ortner');
    $departments[] = array('id' => "1", 'name' => 'Informationstechnologie');
    $departments[] = array('id' => "2", 'name' => 'Elektronik');
    $departments[] = array('id' => "3", 'name' => 'Fachschule');
    $tutors[] = array('id' => "1", 'firstname' => 'Erik', 'lastname' => 'Sacher');
    $tutors[] = array('id' => "2", 'firstname' => 'Bernhard', 'lastname' => 'Loibner');
    $tags[] = array('id' => "1", 'name' => 'Javascript');
    $tags[] = array('id' => "2", 'name' => 'HTML');
    $attachments[] = array('id' => "1", 'name' => "Anhang1", "tmp_name" => "phpAnhang1");
    $attachments[] = array('id' => "2", 'name' => "Anhang2", "tmp_name" => "phpAnhang2");
    $attachments[] = array('id' => "3", 'name' => "Anhang3", "tmp_name" => "phpAnhang3");
    $diplomathesis[] = array('id' => null, 'name' => "DiplomaPDF", "tmp_name" => "PreviewDiploma");
    $summary = 'SUMMARYLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';
    $notes = 'NOTESLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';
    $diploma[] = array('id' => 6, 'title' => "title1", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => $summary, 'notes' => $notes, 'attachments' => array(), 'tags' => $tags);
    $diploma[] = array('id' => 5, 'title' => "title2", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr2", 'upload' => "diplomathesispdf2", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 4, 'title' => "title3", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr3", 'upload' => $diplomathesis, 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 3, 'title' => "title4", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr4", 'upload' => $diplomathesis, 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 2, 'title' => "title5", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr5", 'upload' => $diplomathesis, 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 1, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 7, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 8, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 9, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 10, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 11, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 12, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 13, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 14, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    $diploma[] = array('id' => 15, 'title' => "title6", 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => $summary, 'notes' => $notes, 'attachments' => $attachments, 'tags' => $tags);
    echo json_encode($diploma);
});

/*Flight::route('GET /users', function () {
    $users[] = array('id' => "2", 'email' => 'stefan', 'password' => 'stefan');
    $users[] = array('id' => "1", 'email' => 'markus', 'password' => 'markus');
    $users[] = array('id' => "3", 'email' => 'sebi', 'password' => 'sebi');
    $users[] = array('id' => "4", 'email' => 'karl', 'password' => 'karl');
    echo json_encode($users);
});*/

/**
 * Get list of authors.
 */
Flight::route('GET /authors', function () {
    $authors[] = array('id' => "1", 'firstname' => 'Markus', 'lastname' => 'Humml');
    $authors[] = array('id' => "2", 'firstname' => 'Karl', 'lastname' => 'Heinz');
    $authors[] = array('id' => "3", 'firstname' => 'Stefan', 'lastname' => 'Matl');
    $authors[] = array('id' => "4", 'firstname' => 'Paul', 'lastname' => 'Ortner');
    echo json_encode($authors);
});

/**
 * Get list of tutors.
 */
Flight::route('GET /tutors', function () {
    $tutors[] = array('id' => "1", 'firstname' => 'Erik', 'lastname' => 'Sacher');
    $tutors[] = array('id' => "2", 'firstname' => 'Bernhard', 'lastname' => 'Loibner');
    echo json_encode($tutors);
});

/**
 * Get list of departments.
 */
Flight::route('GET /departments', function () {
    $departments[] = array('id' => "1", 'name' => 'Informationstechnologie');
    $departments[] = array('id' => "2", 'name' => 'Elektronik');
    $departments[] = array('id' => "3", 'name' => 'Fachschule');
    echo json_encode($departments);
});

/**
 * Get list of tags.
 */
Flight::route('GET /tags', function () {
    $tags[] = array('id' => "1", 'name' => 'Javascript');
    $tags[] = array('id' => "2", 'name' => 'HTML');
    $tags[] = array('id' => "3", 'name' => 'MySQL');
    $tags[] = array('id' => "4", 'name' => 'CSS');
    echo json_encode($tags);
});

/*Flight::route('GET /diplomarbeiten/@id', function ($id) {
    $arr1 = array('id' => $id, 'title' => "title1", 'author' => "author1", 'tutor' => "tutor1", 'departments' => "department1", 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => "summary1", 'attachments' => "attachments1", 'tags' => "tags1");
    echo json_encode($arr1);
});*/

/**
 * Delete diploma
 */
Flight::route('DELETE /diplomarbeiten/@id', function ($id) {
    echo "$id";
});

Flight::route('POST /extendedFilter', function () {
    $json = file_get_contents("php://input");
    $extendedFilter = json_decode($json, true);
    echo(json_encode($extendedFilter));
});

Flight::route('POST /search', function () {
    $json = file_get_contents("php://input");
    $search = json_decode($json, true);
    echo(json_encode($search["name"]));
});

/**
 * Save diploma (create and update)
 */
Flight::route('POST /diplomarbeiten', function () {
    $diploma = json_decode($_POST["diploma"], true);

    $uploads_dir = '../uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir);
    }

    // Save diploma file
    if (array_key_exists("diplomaFile", $_FILES)) {
        if ($_FILES["diplomaFile"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["diplomaFile"]["tmp_name"];
            $name = basename($_FILES["diplomaFile"]["tmp_name"]);
            $ext = pathinfo($_FILES["diplomaFile"]["name"], PATHINFO_EXTENSION);
            $name = "{$name}.{$ext}";
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
        }

        // Read file name into diploma data
        $diploma["upload"] = array("name" => $_FILES["diplomaFile"]["name"], "tmp_name" => "./uploads/{$name}");
    }

    // Save attachments
    if (array_key_exists("attachments", $_FILES)) {
        $diploma["attachments"] = array();
        foreach ($_FILES["attachments"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["attachments"]["tmp_name"][$key];
                $name = basename($_FILES["attachments"]["tmp_name"][$key]);
                $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                $name = "{$name}.{$ext}";
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                // Read file name into diploma data
                array_push($diploma["attachments"], array("id" => null, "name" => $_FILES["attachments"]["name"][$key], "tmp_name" => "./uploads/{$name}"));
            }
          }
    }
    if ($diploma["id"] === null) {
        // Create new diploma in db
    } else {
        // Update diploma with id in db
    }
    // Get created/updated diploma from db
    // Save new tags into data base (those that have null as id)

    // Return created/updated diploma as JSON to client
    echo(json_encode($diploma));
});

Flight::route('POST /uploads', function () {
    $uploads_dir = '../uploads';
    /*    if(! is_dir($uploads_dir)) {
            mkdir($uploads_dir);
        }

        foreach ($_FILES["attachments"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["attachments"]["tmp_name"][$key];
                $name = basename($_FILES["attachments"]["tmp_name"][$key]);
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
            }
        }
    */
    echo(json_encode($_FILES["diplomaFile"]));

    if (array_key_exists("attachments", $_FILES)) {
        echo(json_encode($_FILES["attachments"]));
    }
});

Flight::route('POST /login', function () {
    $conn = Flight::db();

    $json = file_get_contents("php://input");
    $user = json_decode($json, true);
    $email = $user["email"];
    $password = $user["password"];
    if ($user["email"] == "logout") {
        $session = 0;
        echo(json_encode($session));
    } else {
        if ($user["email"] == "asdf") {
            $session = 1;
            echo(json_encode($session));
        } else {
            $session = 0;
            echo(json_encode($session));
        }
    }
    $data = $conn->query("SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$password'");

    if ($data->fetchColumn() > 0) {
        echo("hee");
    }

});


Flight::route('POST /register', function () {
    $errorv = false;  //Errorvariable wird bei Fehler gesetzt

    $json = file_get_contents("php://input");
    $users = json_decode($json, true);
    $email = $users["email"];
    $password = $users["password"];
    //$password2 = $users["password2"];
    //$password = hash("sha512", $users["password"]);
    echo($email);
    echo($password);
    //$password2 = hash("sha512", $users["password2"]);
    //echo($password);
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