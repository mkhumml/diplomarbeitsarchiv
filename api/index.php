<?php
/* TODO?
 * Multiselect Listen in der Datenbank - Prüfen ob der Eintrag noch irgenwo Verwendet wird, wenn nicht in der DB löschen
 */


require 'flight/Flight.php';

session_start();
$_SESSION["logged"] = 0;

Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=mydb', 'root', 'root'), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});


/**
 * Get list of diplomas.
 */
Flight::route('GET /diplomarbeiten', function () {

    $conn = Flight::db();
    $vorhanden = false;


    $sql = "SELECT * from diploma";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll();


    foreach ($result as $row) {

        $vorhanden = true;
        $diploma_id = $row["id"];
        $diploma_titel = $row["title"];
        $diploma_summary = $row["summary"];
        $diploma_notes = $row["notes"];
        $diploma_year = $row["year"];
        $diploma_org_name = $row["org_name"];

        $diploma_file = $row["diplomathesis"];
        $diploma_pfad = "uploads/$diploma_file";

        $diplomathesis = array('id' => $diploma_id, 'name' => $diploma_org_name, "tmp_name" => $diploma_pfad);

        $sql_2 = "SELECT * FROM authors_has_diploma WHERE diploma_id = '$diploma_id'";
        $sth_2 = $conn->query($sql_2);
        $res_2 = $sth_2->fetchAll();

        foreach ($res_2 as $row) {

            $author_id = $row["authors_id"];
            $sql_3 = "SELECT * FROM authors WHERE id = '$author_id'";
            $sth_3 = $conn->query($sql_3);
            $res_3 = $sth_3->fetchAll();


            foreach ($res_3 as $row) {

                $ath_id = $row["id"];
                $ath_firstname = $row["firstname"];
                $ath_lastname = $row["lastname"];

                $authors[] = array('id' => $ath_id, 'firstname' => $ath_firstname, 'lastname' => $ath_lastname);

            }

        }


        $sql_4 = "SELECT * FROM tutors_has_diploma WHERE diploma_id = '$diploma_id'";
        $sth_4 = $conn->query($sql_4);
        $res_4 = $sth_4->fetchAll();

        foreach ($res_4 as $row) {

            $tutor_id = $row["tutors_id"];
            $sql_5 = "SELECT * FROM tutors WHERE id = '$tutor_id'";
            $sth_5 = $conn->query($sql_5);
            $res_5 = $sth_5->fetchAll();

            foreach ($res_5 as $row) {

                $tut_id = $row["id"];
                $tut_firstname = $row["firstname"];
                $tut_lastname = $row["lastname"];

                $tutors[] = array('id' => $tut_id, 'firstname' => $tut_firstname, 'lastname' => $tut_lastname);
            }
        }

        $sql_6 = "SELECT * FROM diploma_has_tags WHERE diploma_id = '$diploma_id'";
        $sth_6 = $conn->query($sql_6);
        $res_6 = $sth_6->fetchAll();

       $tags[] = array('id' => null, 'name' => null);

        foreach ($res_6 as $row) {

            $tag_id = $row["tags_id"];
            $sql_7 = "SELECT * FROM tags WHERE id = '$tag_id'";
            $sth_7 = $conn->query($sql_7);
            $res_7 = $sth_7->fetchAll();

            foreach ($res_7 as $row) {

                $t_id = $row["id"];
                $t_name = $row["name"];
                $tags[] = array('id' => $t_id, 'name' => $t_name);
            }

        }

        $sql_8 = "SELECT * FROM diploma_has_deparments WHERE diploma_id = '$diploma_id'";
        $sth_8 = $conn->query($sql_8);
        $res_8 = $sth_8->fetchAll();

        foreach ($res_8 as $row) {

            $dep_id = $row["deparments_id"];
            $sql_9 = "SELECT * FROM deparments WHERE id = '$dep_id'";
            $sth_9 = $conn->query($sql_9);
            $res_9 = $sth_9->fetchAll();

            foreach ($res_9 as $row) {

                $d_id = $row["id"];
                $d_name = $row["name"];
                $departments[] = array('id' => $d_id, 'name' => $d_name);
            }


        }

        $sql_10 = "SELECT * FROM attachments_has_diploma WHERE diploma_id ='$diploma_id'";
        $sth_10 = $conn->query($sql_10);
        $res_10 = $sth_10->fetchAll();

       $attachments[] = array('id' => null, 'name' => null, "tmp_name" => null); //Falls es keine attachments gibt
        //wird leeres array zurückgegeben

        foreach ($res_10 as $row) {

            $attachments_id = $row["attachments_id"];
            $sql_11 = "SELECT * FROM attachments WHERE id = '$attachments_id'";
            $sth_11 = $conn->query($sql_11);
            $res_11 = $sth_11->fetchAll();

            foreach ($res_11 as $row) {

                $a_id = $row["id"];
                $a_name = $row["name"];
                $org_name = $row["org_name"];
                $attachments[] = array('id' => $a_id, 'name' => $org_name, "tmp_name" => "uploads/$a_name");
            }
        }
        $diploma[] = array('id' => $diploma_id, 'title' => $diploma_titel, 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => $diploma_year, 'upload' => $diplomathesis, 'summary' => $diploma_summary, 'notes' => $diploma_notes, 'attachments' => $attachments, 'tags' => $tags);

        unset($tags);
        unset($authors);
        unset($tutors);
        unset($departments);
        unset($diplomathesis);
        unset($attachments);
    }

    if($vorhanden){
        echo json_encode($diploma);

    }else {
        $diploma[] = array('id' => "", 'title' => "Keine Diplomarbeit gefunden", 'authors' => "", 'tutors' => "", 'departments' => "", 'year' => "", 'upload' => "", 'summary' => "", 'notes' => "", 'attachments' => "", 'tags' => "");
        echo json_encode($diploma);
    }
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

    $conn = Flight::db();
    $sql = "SELECT * FROM authors";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    foreach ($result as $row) {

        $id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $authors[] = array('id' => $id, 'firstname' => $firstname, 'lastname' => $lastname);
    }
    echo json_encode($authors);
});

/**
 * Get list of tutors.
 */
Flight::route('GET /tutors', function () {


    $conn = Flight::db();
    $sql = "SELECT * FROM tutors";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    foreach ($result as $row) {

        $id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $tutors[] = array('id' => $id, 'firstname' => $firstname, 'lastname' => $lastname);
    }
    echo json_encode($tutors);
});

/**
 * Get list of departments.
 */
Flight::route('GET /departments', function () {


    $conn = Flight::db();
    $sql = "SELECT * FROM deparments";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    foreach ($result as $row) {

        $id = $row['id'];
        $name = $row['name'];
        $departments[] = array('id' => $id, 'name' => $name);
    }
    echo json_encode($departments);
});

/**
 * Get list of tags.
 */
Flight::route('GET /tags', function () {


    $conn = Flight::db();
    $sql = "SELECT * FROM tags";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück

    foreach ($result as $row) {

        $id = $row['id'];
        $name = $row['name'];
        $tags[] = array('id' => $id, 'name' => $name);

    }
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
    $conn = Flight::db();
    // Löschung des Inhaltes der Verbindungstabellen um danach die Dateien im Ordner zu löschen
    $sql = "DELETE FROM attachments_has_diploma WHERE diploma_id ='$id'";
    $conn->query($sql);
    $sql = "DELETE FROM authors_has_diploma WHERE diploma_id ='$id'";
    $conn->query($sql);
    $sql = "DELETE FROM diploma_has_deparments WHERE diploma_id = '$id'";
    $conn->query($sql);
    $sql = "DELETE FROM diploma_has_tags WHERE diploma_id = '$id'";
    $conn->query($sql);
    $sql = "DELETE FROM tutors_has_diploma WHERE diploma_id = '$id'";
    $conn->query($sql);
    //  Löschung vom Attachment im Ordner
    $sql = "SELECT * from attachments WHERE diploma_id = '$id'";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    foreach ($result as $row) {
        $attachment_name = $row["name"];
        unlink("../uploads/$attachment_name");

    }
    $sql = "DELETE from attachments WHERE diploma_id = '$id'";
    $sth = $conn->query($sql);
    // Löschung vom der Diplomarbeit im Ordner
    $sql = "SELECT * FROM diploma WHERE id = '$id'";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    foreach ($result as $row) {
        $diploma_name = $row["diplomathesis"];
        unlink("../uploads/$diploma_name");
    }
    $sql = "DELETE FROM diploma WHERE id = '$id'";
    $sth = $conn->query($sql);

});

/**
 * Save diploma (create and update)
 */
Flight::route('POST /diplomarbeiten', function () {

    $conn = Flight::db();
    $diploma = json_decode($_POST["diploma"], true);

    if ($diploma["id"] == null) {
        $uploads_dir = '../uploads';
        if (!is_dir($uploads_dir)) { //Prüfe ob Directory uploads schon vorhanden
            mkdir($uploads_dir);
        }
        $title = $diploma["title"];
        $note = "NULL";
        $summary = "NULL";
        $year = $diploma["year"];

        if (!(isset($diploma["summary"]))) { //Prüft ob eine Zusammenfassung eingegeben wurde
            $summary = $diploma["summary"];

        }

        if (!(isset($diploma["notes"]))) { //Prüft ob Notizen eingegeben wurden
            $note = $diploma["notes"];

        }


        //  $authors1__id = $diploma["authors"][0]["id"];
        // $authors1_firstname = $diploma["authors"][0]["firstname"];
        //  $authors1_lastname = $diploma["authors"][0]["lastname"];

        $anzAuthors = count($diploma["authors"]); //Berechne Größe des Arrays $diploma["authors"];
        $anzTutors = count($diploma["tutors"]);
        $anzTags = count($diploma["tags"]);
        $anzDepartments = count($diploma["departments"]);



        //Struktur eines FIle Arrays https://secure.php.net/manual/de/reserved.variables.files.php
        $name = "";
        if (array_key_exists("diplomaFile", $_FILES)) { //Prüft ob im array $_FILES ( FILE ARRAY) ein Inhalt "diplomaFile" vorhanden ist
            if ($_FILES["diplomaFile"]["error"] == UPLOAD_ERR_OK) { //Prüft ob error beim upload ( Fehlercode)
                $tmp_name = $_FILES["diplomaFile"]["tmp_name"];
                $name = basename($_FILES["diplomaFile"]["tmp_name"]); //basename gibt letzten Namensteil einer Pfadangabe zurück
                $ext = pathinfo($_FILES["diplomaFile"]["name"], PATHINFO_EXTENSION);
                $name = "{$name}.{$ext}";
                move_uploaded_file($tmp_name, "$uploads_dir/$name"); //Move file in das directory
                $org_name = $_FILES["diplomaFile"]["name"];
                $sql = "INSERT INTO diploma (title,summary,notes,diplomathesis,year,org_name) VALUES ('" . $title . "','" . $summary . "','" . $note . "','" . $name . "','" . $year . "','" . $org_name . "')";
                $conn->query($sql);
                $diploma["upload"] = array("name" => $_FILES["diplomaFile"]["name"], "tmp_name" => "./uploads/{$name}");
            }
            else { //Falls Fehler beim Upload der Diplomarbeit, gebe Fehlercode aus und beende
             $error = $_FILES["diplomaFile"]["error"];
             die("Fehler beim Upload der Diplomarbeit. \nErrorcode für das Filearray: '$error'");
            }
            // Read file name into diploma data
        }else{
            die("Diplomafile nicht vorhanden!\n");
        }

        $sql_select = "SELECT * FROM diploma WHERE diplomathesis = '$name'"; //Lese id raus wo die neue diplomathesis eingetragen wurde mithilfe des filenamen
        $stmt = $conn->query($sql_select);
        $row = $stmt->fetch(PDO::FETCH_ASSOC); //Gibt array zurück wo man die Werte auslesen kann aus dem select statement
        $diploma_id = $row["id"]; //Wird benötigt um bei den Zwischentabellen einzutragen wie z.B. bei Attachments


        if (array_key_exists("attachments", $_FILES)) { //Attachments einfügen, zuerst geprüft ob es ein attachment gibt
            $diploma["attachments"] = array();
            foreach ($_FILES["attachments"]["error"] as $key => $error) {
                $name = "";
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["attachments"]["tmp_name"][$key];
                    $name = basename($_FILES["attachments"]["tmp_name"][$key]);
                    $ext = pathinfo($_FILES["attachments"]["name"][$key], PATHINFO_EXTENSION);
                    $name = "{$name}.{$ext}";
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                    // Read file name into diploma data
                    $org_name = $_FILES["attachments"]["name"][$key];
                    $sql = "INSERT INTO attachments (name,diploma_id,org_name) VALUES ('" . $name . "','" . $diploma_id . "','" . $org_name . "')";
                    $conn->query($sql);

                    $sql = "SELECT * FROM attachments WHERE name ='$name'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $attachment_id = $row["id"];
                    $sql = "INSERT INTO attachments_has_diploma(attachments_id,diploma_id) values ('" . $attachment_id . "','" . $diploma_id . "')";
                    $conn->query($sql);

                    array_push($diploma["attachments"], array("id" => $attachment_id, "name" => $_FILES["attachments"]["name"][$key], "tmp_name" => "./uploads/{$name}"));

                }else{ //Falls Fehler beim Upload der attachments, entferne Eintrag aus der diploma Tabelle sowie die Dateien
                    /*
                  * Falls mehrere Attachments schon upgeloadet wurden und erst dann ein Fehler entstanden ist
                  * müssen diese auch entfernt werden also ... und die Einträge in der tabelle attachments
                   * sowie attachments_has_diploma
                   */

                    $sql = "DELETE FROM attachments_has_diploma WHERE diploma_id ='$diploma_id'";
                    $conn->query($sql);


                    $sql = "SELECT * from attachments WHERE diploma_id = '$diploma_id'";
                    $sth = $conn->query($sql);
                    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
                    foreach ($result as $row) {
                        $attachment_name = $row["name"];
                        unlink("../uploads/$attachment_name");

                    }
                    $sql = "DELETE from attachments WHERE diploma_id = '$diploma_id'";
                    $sth = $conn->query($sql);

                    /*
                     *
                     * Die hochgeladene Diplomarbeit und der Eintrag in der Tabelle diploma müssen entfernt werden
                     */
                    $sql = "SELECT * FROM diploma WHERE id = '$diploma_id'"; //Entferne die Diplomarbeit
                    $sth = $conn->query($sql);
                    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
                    foreach ($result as $row) {
                        $diploma_name = $row["diplomathesis"];
                        unlink("../uploads/$diploma_name");
                    }

                    $sql ="DELETE FROM diploma WHERE id = '$diploma_id'";
                    $conn->query($sql);
                    die("Error beim Upload von Attachments. Errorcode für das Filearray :".$error);
                }
            }
        }


        for ($var = 0; $var < $anzAuthors; $var++) {
            $author_id = $diploma["authors"][$var]["id"];

            foreach ($diploma["authors"][$var] as $stat => $value) {

                if ($author_id == null) { // Wenn ID net gesetzt, gibt es noch kein DB Eintrag

                    $firstname = $diploma["authors"][$var]["firstname"];
                    $lastname = $diploma["authors"][$var]["lastname"];
                    $sql = "INSERT INTO authors(firstname,lastname) values ('" . $firstname . "','" . $lastname . "')";
                    $conn->query($sql);
                    $sql = "SELECT * FROM authors WHERE firstname = '$firstname' && lastname = '$lastname'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $author_id = $row["id"]; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht
                    $sql = "INSERT INTO authors_has_diploma (authors_id,diploma_id) values ('" . $author_id . "','" . $diploma_id . "')";
                    $conn->query($sql);
                    $author_id = "hey";

                } else if ($author_id != "hey") {

                    $sql = "INSERT INTO authors_has_diploma (authors_id,diploma_id) values ('" . $author_id . "','" . $diploma_id . "')";
                    $conn->query($sql);

                    $author_id = "hey";
                }
            }
        }


        for ($var = 0; $var < $anzDepartments; $var++) //Zum einfügen von Tutors in die Tabelle
        {
            $departments_id = $diploma["departments"][$var]["id"];


            foreach ($diploma["departments"][$var] as $stat => $value) {

                if ($departments_id == null) { // Wenn ID net gesetzt, gibt es noch kein DB Eintrag


                    $name = $diploma["departments"][$var]["name"];

                    $sql = "INSERT INTO deparments(name) values ('" . $name . "')";
                    $conn->query($sql);

                    $sql = "SELECT * FROM deparments WHERE name = '$name'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $departments_id = $row["id"];


                    $sql = "INSERT INTO diploma_has_deparments (diploma_id,deparments_id) values ('" . $diploma_id . "','" . $departments_id . "')";
                    $conn->query($sql);


                    $departments_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht

                } else if ($departments_id != "hey") {
                    $sql = "INSERT INTO diploma_has_deparments (diploma_id,deparments_id) values ('" . $diploma_id . "','" . $departments_id . "')";
                    $conn->query($sql);

                    $departments_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht

                }

            }
        }

        for ($var = 0; $var < $anzTutors; $var++) //Zum einfügen von Departments in die tabelle
        {
            $tutors_id = $diploma["tutors"][$var]["id"];

            foreach ($diploma["tutors"][$var] as $stat => $value) {
                if ($tutors_id == null) { // Wenn ID net gesetzt, gibt es noch kein DB Eintrag

                    $firstname = $diploma["tutors"][$var]["firstname"];
                    $lastname = $diploma["tutors"][$var]["lastname"];

                    $sql = "INSERT INTO tutors(firstname,lastname) values ('" . $firstname . "','" . $lastname . "')";
                    $conn->query($sql);


                    $sql = "SELECT * FROM tutors WHERE firstname = '$firstname' && lastname ='$lastname'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $tutors_id = $row["id"];

                    $sql = "INSERT INTO tutors_has_diploma (tutors_id,diploma_id) values ('" . $tutors_id . "','" . $diploma_id . "')";
                    $conn->query($sql);


                    $tutors_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht

                } else if ($tutors_id != "hey") {

                    $sql = "INSERT INTO tutors_has_diploma (tutors_id,diploma_id) values ('" . $tutors_id . "','" . $diploma_id . "')";
                    $conn->query($sql);
                    $tutors_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht
                }
            }
        }



        for ($var = 0; $var < $anzTags; $var++) //Zum einfügen von Departments in die tabelle
        {
            $tags_id = $diploma["tags"][$var]["id"];

            foreach ($diploma["tags"][$var] as $stat => $value) {

                if ($tags_id == null) { // Wenn ID net gesetzt, gibt es noch kein DB Eintrag

                    $name = $diploma["tags"][$var]["name"];
                    $sql = "INSERT INTO tags(name) values ('" . $name . "')";
                    $conn->query($sql);


                    $sql = "SELECT * FROM tags WHERE name = '$name'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $tags_id = $row["id"];

                    $sql = "INSERT INTO diploma_has_tags (diploma_id,tags_id) values ('" . $diploma_id . "','" . $tags_id . "')";
                    $conn->query($sql);
                    $tags_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht


                } else if ($tags_id != "hey") {


                    $sql = "INSERT INTO diploma_has_tags (diploma_id,tags_id) values ('" . $diploma_id . "','" . $tags_id . "')";
                    $conn->query($sql);

                    $tags_id = "hey"; //Damit es bei diesem durchgang nicht mehr in die if verzeiweugn reingeht
                }
            }
        }

        echo json_encode($diploma);



    } else {


        /*
       *
       *  Hier müsste der Code zum bearbeiten einer bereits bestehen Diplomarbeit stehen wo Veränderungen übernommen werden
       */
/*
        $d_id = $diploma["id"];
        $d_title = $diploma["title"];
        $d_summary = $diploma["summary"];
        $d_notes = $diploma["notes"];
        $d_year = $diploma["year"];


        $sql = "UPDATE diploma SET title = '$d_title',summary = '$d_summary', notes = '$d_notes', year = '$d_year' WHERE id = '$d_id'";
        $conn->query($sql);
*/

        echo json_encode($diploma);
    }

});


Flight::route('POST /login', function () {


    $conn = Flight::db();

    $json = file_get_contents("php://input");
    $users = json_decode($json, true);

    $password = hash("sha512", $users["password"]);
    $email = $users["email"];


    $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND password ='" . $password . "'"; //SQL Statement zum suchen aller Einträge die mit der eingegebenen email übereinstimmen
    $res = $conn->query($sql);
    if ($res->fetchColumn() > 0) { // Wenn Die Anzahl der rows größer als 0 ist, gibt es ein Eintrag in der DB und somit login :)
        // Session Variable login wird auf 1 gesetzt wenn user erfolgreich eingeloggt sonst ist sie 0
        echo("1");
        $_SESSION["logged"] = 1;
    } else {
        echo("0");

    }

});


Flight::route('GET /logout', function () {
    $_SESSION["logged"] = 0;
    echo(0); // 0 = false also ausgeloggt, 1 = true eingeloggt
    session_unset();
    session_destroy();
});

Flight::route('POST /register', function () {
    $conn = Flight::db();
    $json = file_get_contents("php://input");
    $users = json_decode($json, true);
    $email = $users["email"];
    $password = $users["password"];
    $password = hash("sha512", $users["password"]);
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $res = $conn->query($sql); // Führer SQL Statement aus und speicher ergebnis ( Objekt falls vorhanden in $res )
    if ($res->fetchColumn() > 0) { //Falls Eintrag vorhanden dann wird email bereits verwendet
        echo "0";
    } else {
        $insert = "INSERT INTO users( email, password) VALUES ('" . $email . "','" . $password . "')";
        if ($conn->query($insert) == true) {
            echo "1";
        } else {
            echo "0";
        }

    }

});

Flight::route('POST /extendedFilter', function () {
    $json = file_get_contents("php://input");
    $extendedFilter = json_decode($json, true);


    $sql = "SELECT * FROM diploma d";
    $vals = []; //Array deklarieren

    array_push ($vals, $sql);
    $dep = $extendedFilter["departments"][0];
    $tag = $extendedFilter["tags"][0];
    $auth = $extendedFilter["authors"][0];
    $tuth = $extendedFilter["tutors"][0];


    if(!(empty($dep))){

       $sql = " JOIN diploma_has_deparments dp ON d.id = dp.diploma_id AND ( ";
       array_push ($vals, $sql);

        for($i = 0; $i < count($dep); $i++){
            $dep_id = $dep[$i]["id"];
            $sql = $i==0?" ":" OR ";
            $sql.=" dp.deparments_id = '$dep_id' ";
          array_push($vals, $sql);

        }
        array_push($vals, ")");
    }

    if(!(empty($tag))){
        $sql = " JOIN diploma_has_tags dt ON d.id = dt.diploma_id AND ( ";
        array_push ($vals, $sql);
        for($i = 0; $i < count($tag); $i++){
            $tag_id = $tag[$i]["id"];
            $sql = $i==0?" ":" OR ";
            $sql.=" dt.tags_id = '$tag_id' ";
            array_push($vals, $sql);

        }

        array_push($vals, ")");
    }

   if(!(empty($auth))){
       $sql = " JOIN authors_has_diploma ad ON d.id = ad.diploma_id AND ( ";
       array_push ($vals, $sql);
       for($i = 0; $i < count($auth); $i++){
           $auth_id = $auth[$i]["id"];
           $sql = $i==0?" ":" OR ";
           $sql.= "  ad.authors_id = '$auth_id' ";
           array_push($vals, $sql);

       }
       array_push($vals, ")");
   }

   if(!(empty($tuth))){
       $sql = " JOIN tutors_has_diploma td ON d.id = td.diploma_id AND ( ";
       array_push ($vals, $sql);
       for($i = 0; $i < count($tuth); $i++){
           $tuth_id = $tuth[$i]["id"];
           $sql = $i==0?" ":" OR ";
           $sql.=" td.tutors_id = '$tuth_id' ";
           array_push($vals, $sql);

       }
       array_push($vals, ")");
   }

   if(!(empty($extendedFilter["year"]))){
        $year =$extendedFilter["year"];
        $sql = " WHERE d.year = '$year'";
       array_push($vals, $sql);
   }


    $sql = implode("",$vals); //Verbindet ein Array zu einem String

    echo $sql;


 // echo(json_encode($extendedFilter));

});


Flight::route('POST /search', function () {
    $conn = Flight::db();
    $json = file_get_contents("php://input");
    $search = json_decode($json, true);
    $title_s = $search["name"];

    $sql = "SELECT * FROM diploma WHERE title = '$title_s'";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück


    $vorhanden = false;

    foreach ($result as $row) {

        $vorhanden = true;
        $diploma_id = $row["id"];
        $diploma_titel = $row["title"];
        $diploma_summary = $row["summary"];
        $diploma_notes = $row["notes"];
        $diploma_year = $row["year"];
        $diploma_org_name = $row["org_name"];
        //hier Fehlt Diplomathesis Datei und attachments

        $diploma_file = $row["diplomathesis"];
        $diploma_pfad = "uploads/$diploma_file";

        $diplomathesis[] = array('id' => $diploma_id, 'name' => $diploma_org_name, "tmp_name" => $diploma_pfad);

        $sql_2 = "SELECT * FROM authors_has_diploma WHERE diploma_id = '$diploma_id'";
        $sth_2 = $conn->query($sql_2);
        $res_2 = $sth_2->fetchAll();

        foreach ($res_2 as $row) {

            $author_id = $row["authors_id"];
            $sql_3 = "SELECT * FROM authors WHERE id = '$author_id'";
            $sth_3 = $conn->query($sql_3);
            $res_3 = $sth_3->fetchAll();


            foreach ($res_3 as $row) {
                $ath_id = $row["id"];
                $ath_firstname = $row["firstname"];
                $ath_lastname = $row["lastname"];

                $authors[] = array('id' => $ath_id, 'firstname' => $ath_firstname, 'lastname' => $ath_lastname);

            }
        }
        $sql_4 = "SELECT * FROM tutors_has_diploma WHERE diploma_id = '$diploma_id'";
        $sth_4 = $conn->query($sql_4);
        $res_4 = $sth_4->fetchAll();

        foreach ($res_4 as $row) {

            $tutor_id = $row["tutors_id"];
            $sql_5 = "SELECT * FROM tutors WHERE id = '$tutor_id'";
            $sth_5 = $conn->query($sql_5);
            $res_5 = $sth_5->fetchAll();

            foreach ($res_5 as $row) {

                $tut_id = $row["id"];
                $tut_firstname = $row["firstname"];
                $tut_lastname = $row["lastname"];

                $tutors[] = array('id' => $tut_id, 'firstname' => $tut_firstname, 'lastname' => $tut_lastname);
            }
        }

        $sql_6 = "SELECT * FROM diploma_has_tags WHERE diploma_id = '$diploma_id'";
        $sth_6 = $conn->query($sql_6);
        $res_6 = $sth_6->fetchAll();

        foreach ($res_6 as $row) {

            $tag_id = $row["tags_id"];
            $sql_7 = "SELECT * FROM tags WHERE id = '$tag_id'";
            $sth_7 = $conn->query($sql_7);
            $res_7 = $sth_7->fetchAll();

            foreach ($res_7 as $row) {

                $t_id = $row["id"];
                $t_name = $row["name"];
                $tags[] = array('id' => $t_id, 'name' => $t_name);
            }

        }

        $sql_8 = "SELECT * FROM diploma_has_deparments WHERE diploma_id = '$diploma_id'";
        $sth_8 = $conn->query($sql_8);
        $res_8 = $sth_8->fetchAll();

        foreach ($res_8 as $row) {

            $dep_id = $row["deparments_id"];
            $sql_9 = "SELECT * FROM deparments WHERE id = '$dep_id'";
            $sth_9 = $conn->query($sql_9);
            $res_9 = $sth_9->fetchAll();

            foreach ($res_9 as $row) {

                $d_id = $row["id"];
                $d_name = $row["name"];
                $departments[] = array('id' => $d_id, 'name' => $d_name);
            }
        }
        $sql_10 = "SELECT * FROM attachments_has_diploma WHERE diploma_id ='$diploma_id'";
        $sth_10 = $conn->query($sql_10);
        $res_10 = $sth_10->fetchAll();

        $attachments[] = array('id' => null, 'name' => null, "tmp_name" => null); //Falls es keine attachments gibt
        //wird leeres array zurückgegeben

        foreach ($res_10 as $row) {

            $attachments_id = $row["attachments_id"];
            $sql_11 = "SELECT * FROM attachments WHERE id = '$attachments_id'";
            $sth_11 = $conn->query($sql_11);
            $res_11 = $sth_11->fetchAll();

            foreach ($res_11 as $row) {

                $a_id = $row["id"];
                $a_name = $row["name"];
                $org_name = $row["org_name"];
                $attachments[] = array('id' => $a_id, 'name' => $org_name, "tmp_name" => "uploads/$a_name");
            }
        }
        $diploma[] = array('id' => $diploma_id, 'title' => $diploma_titel, 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => $diploma_year, 'upload' => $diplomathesis, 'summary' => $diploma_summary, 'notes' => $diploma_notes, 'attachments' => $attachments, 'tags' => $tags);
    }

    if ($vorhanden) {
        echo json_encode($diploma);
    } else {

        $diploma[] = array('id' => "", 'title' => "Keine Diplomarbeit gefunden", 'authors' => "", 'tutors' => "", 'departments' => "", 'year' => "", 'upload' => "", 'summary' => "", 'notes' => "", 'attachments' => "", 'tags' => "");
        echo json_encode($diploma);
    }


});

Flight::route('POST /resetpassword', function () {

    $conn = Flight::db();
    $json = file_get_contents("php://input");
    $reset = json_decode($json, true);

    $from = "diplomarbeitsarchiv@htl-donaustadt.at";
    $email =  $reset["email"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = $conn->query($sql);
    if($res->fetchColumn() > 0){
        $password = substr(md5(uniqid(rand(),1)),3,10); // Geniere ein neues 10 Zeichen langes Passwort
        echo $password;
        $password = hash("sha512",$password);
        mail($email,"Passwort Reset","Ihr neues Passwort lautet : ".$password,$from); // Problem hier, mails kommen nicht an
        $sql = "UPDATE users SET password ='".$password."' WHERE email='".$email."'";
        if($conn->query($sql)){
            echo "1";
        }else{
            echo "0";
        }
    }


});

Flight::start();
?>