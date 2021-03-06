<?php
require 'flight/Flight.php';

session_start();
$_SESSION["logged"] = 0;

Flight::register('db', 'PDO', array('mysql:host=localhost;port=3306;dbname=diplomarbeitsarchiv', 'root', 'root'), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

/**
 * Get list of diplomas.
 */
Flight::route('GET /diplomarbeiten', function () {

    $conn = Flight::db();
    $sql = "SELECT * from diploma ORDER BY id DESC";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll();
    $diplomas = readDiplomas($conn, $result);
    echo json_encode($diplomas);
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

    $authors = [];
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

    $tutors = [];
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

    $departments = [];
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

    $tags = [];
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
    try {
        $conn->beginTransaction();
        // Delete all relations of the diploma
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

        // Delete attachments from upload folder
        $sql = "SELECT * from attachments WHERE diploma_id = '$id'";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll();
        foreach ($result as $attachment) {
            $file = realpath("../uploads/" . $attachment['name']);
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Delete attachments
        $sql = "DELETE from attachments WHERE diploma_id = '$id'";
        $conn->query($sql);

        // Delete diploma file from upload folder
        $sql = "SELECT * FROM diploma WHERE id = '$id'";
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $file = realpath("../uploads/" . $result["diplomathesis"]);
        if (is_file($file)) {
            unlink($file);
        }

        // Delete diploma
        $sql = "DELETE FROM diploma WHERE id = '$id'";
        $conn->query($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Fehler beim Speichern der Diplomarbeit:" . $e);
    }
});

/**
 * Save diploma (create and update)
 */
Flight::route('POST /diplomarbeiten', function () {

    // Connect to database
    $conn = Flight::db();

    // Convert JSON object into diploma array
    $diploma = json_decode($_POST["diploma"], true);

    // Save uploaded diploma file
    saveDiplomaFile($diploma);
    saveAttachmentsFiles($diploma);

    // Save diploma in database
    try {
        $conn->beginTransaction();
        saveDiploma($conn, $diploma);
        saveAttachments($conn, $diploma);
        saveAuthors($conn, $diploma);
        saveTutors($conn, $diploma);
        saveDepartments($conn, $diploma);
        saveTags($conn, $diploma);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Fehler beim Speichern der Diplomarbeit:" . $e);
    }

    // Convert diploma array into JSON object
    echo json_encode($diploma);
});

Flight::route('POST /login', function () {


    $conn = Flight::db();

    $json = file_get_contents("php://input");
    $users = json_decode($json, true);
    if ($users["email"] == "logout") {
        setcookie("user", "", time() - 3600, "/");
        echo(0);
    } else {
        $password = hash("sha512", $users["password"]);
        $email = $users["email"];
        $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND password ='" . $password . "'"; //SQL Statement zum suchen aller Einträge die mit der eingegebenen email übereinstimmen
        $res = $conn->query($sql);
        if ($res->fetchColumn() > 0) { // Wenn Die Anzahl der rows größer als 0 ist, gibt es ein Eintrag in der DB und somit login :)
            //setcookie("user", $email, time() + (86400 * 30), "/");
            $_SESSION["logged"] = 1;
            echo(1);
        } else {
            echo(0);
        }
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

/**
 * Extended search.
 */
Flight::route('POST /extendedFilter', function () {

    $json = file_get_contents("php://input");
    $extendedFilter = json_decode($json, true);

    $conn = Flight::db();

    $sql = createExtendedFilterQuery($extendedFilter);
    $sth = $conn->query($sql);
    $result = $sth->fetchAll();
    $diplomas = readDiplomas($conn, $result);
    echo json_encode($diplomas);
});

Flight::route('POST /search', function () {

    $json = file_get_contents("php://input");
    $search = json_decode($json, true);
    $title_s = $search["name"];

    $conn = Flight::db();
    $sql = "SELECT * FROM diploma WHERE title LIKE '%$title_s%'";
    $sth = $conn->query($sql);
    $result = $sth->fetchAll(); // Gibt alle Einträge von der DB als Array zurück
    $diplomas = readDiplomas($conn, $result);
    echo json_encode($diplomas);
});

Flight::route('POST /resetpassword', function () {

    $conn = Flight::db();
    $json = file_get_contents("php://input");
    $reset = json_decode($json, true);

    $from = "diplomarbeitsarchiv@htl-donaustadt.at";
    $email = $reset["email"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = $conn->query($sql);
    if ($res->fetchColumn() > 0) {
        $password = substr(md5(uniqid(rand(), 1)), 3, 10); // Geniere ein neues 10 Zeichen langes Passwort
        echo $password;
        $password = hash("sha512", $password);
        mail($email, "Passwort Reset", "Ihr neues Passwort lautet : " . $password, $from); // Problem hier, mails kommen nicht an
        $sql = "UPDATE users SET password ='" . $password . "' WHERE email='" . $email . "'";
        if ($conn->query($sql)) {
            echo "1";
        } else {
            echo "0";
        }
    }


});

function createExtendedFilterQuery($extendedFilter)
{
    $sql = "SELECT * FROM diploma ";
    $subQueries = createExtendedFilterSubQueries($extendedFilter);
    if ($subQueries != null) {
        $sql .= "WHERE id IN( " . $subQueries . " )";
    }

    if (array_key_exists("year", $extendedFilter) && $extendedFilter["year"] != "") {
        if ($subQueries != null) {
            $sql .= " AND ";
        } else {
            $sql .= " WHERE ";
        }
        $sql .= "year = '" . $extendedFilter["year"] . "' ";
    }

    $sql .= "ORDER BY id DESC";
    return $sql;
}

function createExtendedFilterSubQueries($extendedFilter)
{

    $filters = null;
    if (sizeof($extendedFilter["authors"]) > 0) {
        $filters[] = array("key" => "authors", "table" => "authors_has_diploma", "id" => "authors_id");
    }
    if (sizeof($extendedFilter["tutors"]) > 0) {
        $filters[] = array("key" => "tutors", "table" => "tutors_has_diploma", "id" => "tutors_id");
    }
    if (sizeof($extendedFilter["departments"]) > 0) {
        $filters[] = array("key" => "departments", "table" => "diploma_has_deparments", "id" => "deparments_id");
    }
    if (sizeof($extendedFilter["tags"]) > 0) {
        $filters[] = array("key" => "tags", "table" => "diploma_has_tags", "id" => "tags_id");
    }

    if ($filters != null) {
        return createExtendedFilterSubQuery($filters, $extendedFilter);
    } else {
        return null;
    }
}

function createExtendedFilterSubQuery(&$filters, $extendedFilter)
{

    // Get and remove first filter entry for recursion
    $filter = array_shift($filters);
    $sql = "SELECT d.id FROM ";
    if ($filters != null) {
        $sql .= "( " . createExtendedFilterSubQuery($filters, $extendedFilter) . " ) d ";
    } else {
        $sql .= "diploma d ";
    }
    $sql .= "JOIN " . $filter["table"] . " ref ON d.id = ref.diploma_id ";
    $sql .= "WHERE ";
    foreach ($extendedFilter[$filter["key"]] as $key => $val) {
        $sql .= $key == 0 ? "" : " OR ";
        $sql .= "ref." . $filter["id"] . " = '" . $val["id"] . "' ";
    }
    $sql .= "GROUP BY id HAVING COUNT(d.id) = " . sizeof($extendedFilter[$filter["key"]]);
    return $sql;
}

function readDiplomas($conn, $result)
{
    $diplomas = [];
    foreach ($result as $row) {
        $diploma_id = $row["id"];
        $diploma_titel = $row["title"];
        $diploma_summary = $row["summary"];
        $diploma_notes = $row["notes"];
        $diploma_year = $row["year"];
        $diploma_org_name = $row["org_name"];
        $tags = [];
        $authors = [];
        $tutors = [];
        $departments = [];
        $attachments = [];

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

        $diplomas[] = array('id' => $diploma_id, 'title' => $diploma_titel, 'authors' => $authors, 'tutors' => $tutors, 'departments' => $departments, 'year' => $diploma_year, 'upload' => $diplomathesis, 'summary' => $diploma_summary, 'notes' => $diploma_notes, 'attachments' => $attachments, 'tags' => $tags);

        unset($tags);
        unset($authors);
        unset($tutors);
        unset($departments);
        unset($diplomathesis);
        unset($attachments);
    }
    return $diplomas;
}

function saveDiploma($conn, &$diploma)
{
    $id = $diploma["id"];
    $title = $diploma["title"];
    $year = $diploma["year"];
    $summary = $diploma["summary"];
    $notes = $diploma["notes"];
    if ($diploma["upload"] !== null) {
        $diplomathesis = basename($diploma["upload"]["tmp_name"]);
        $org_name = $diploma["upload"]["name"];
    } else {
        $diplomathesis = NULL;
        $org_name = NULL;
    }

    if ($diploma["id"] == null) {
        // Create new diploma
        $sql = "INSERT INTO diploma (title, year, summary, notes, diplomathesis, org_name) 
                VALUES ('" . $title . "','" . $year . "','" . $summary . "','" . $notes . "','" . $diplomathesis . "','" . $org_name . "')";
        $conn->query($sql);

        // Get id of created diploma
        $id = $conn->lastInsertId();
        $diploma["id"] = $id;
    } else {
        // Update existing diploma
        $sql = "UPDATE diploma 
                SET title = '$title', year = '$year', summary = '$summary', notes = '$notes', diplomathesis = '$diplomathesis', org_name = '$org_name'  
                WHERE id = '$id'";
        $conn->query($sql);
    }
}

function saveAttachments($conn, &$diploma)
{
    foreach ($diploma["attachments"] as $key => $attachment) {
        $sql = "INSERT INTO attachments (diploma_id, name, org_name) 
                VALUES ('" . $diploma['id'] . "','" . basename($attachment['tmp_name']) . "','" . $attachment['name'] . "')";
        $conn->query($sql);
        $diploma["attachments"][$key]["id"] = $conn->lastInsertId();

        // FIXME - Tabelle unnötig da 1:n nicht n:m
        $sql = "INSERT INTO attachments_has_diploma (diploma_id, attachments_id) 
                VALUES ('" . $diploma['id'] . "','" . $diploma["attachments"][$key]["id"] . "')";
        $conn->query($sql);
    }
}

function saveAuthors($conn, &$diploma)
{
    $attachedAuthorIds = [];

    // Create and authors
    foreach ($diploma["authors"] as $key => $author) {
        $id = $author['id'];
        if ($id == null) {
            // Add new author
            $sql = "INSERT INTO authors(firstname, lastname) VALUES ('" . $author['firstname'] . "','" . $author['lastname'] . "')";
            $conn->query($sql);
            $id = $conn->lastInsertId();
            $diploma["authors"][$key]["id"] = $id;
        }
        array_push($attachedAuthorIds, $id);

        // Check if author is already attached to diploma
        $sql = "SELECT * FROM authors_has_diploma WHERE diploma_id = " . $diploma['id'] . " AND authors_id = " . $id;
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // Attach author to diploma
            $sql = "INSERT INTO authors_has_diploma(diploma_id, authors_id) 
                    VALUES (" . $diploma["id"] . "," . $id . ")";
            $conn->query($sql);
        }
    }

    // Detach authors
    if (sizeof($attachedAuthorIds) > 0) {
        $sql = "DELETE FROM authors_has_diploma WHERE diploma_id = " . $diploma['id'] . " AND authors_id NOT IN(" . implode(",", $attachedAuthorIds) . ")";
        $conn->query($sql);
    }
}

function saveTutors($conn, &$diploma)
{
    $attachedTutorIds = [];
    // Create and tutors
    foreach ($diploma["tutors"] as $key => $tutor) {
        $id = $tutor['id'];
        if ($id == null) {
            // Add new tutor
            $sql = "INSERT INTO tutors(firstname, lastname) VALUES ('" . $tutor['firstname'] . "','" . $tutor['lastname'] . "')";
            $conn->query($sql);
            $id = $conn->lastInsertId();
            $diploma["tutors"][$key]["id"] = $id;
        }
        array_push($attachedTutorIds, $id);

        // Check if tutor is already attached to diploma
        $sql = "SELECT * FROM tutors_has_diploma WHERE diploma_id = " . $diploma['id'] . " AND tutors_id = " . $id;
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // Attach tutor to diploma
            $sql = "INSERT INTO tutors_has_diploma(diploma_id, tutors_id) 
                    VALUES (" . $diploma["id"] . "," . $id . ")";
            $conn->query($sql);
        }
    }
    // Detach tutors
    if (sizeof($attachedTutorIds) > 0) {
        $sql = "DELETE FROM tutors_has_diploma WHERE diploma_id = " . $diploma['id'] . " AND tutors_id NOT IN(" . implode(",", $attachedTutorIds) . ")";
        $conn->query($sql);
    }
}

function saveDepartments($conn, &$diploma)
{
    $attachedDepartmentIds = [];
    // Create and department
    foreach ($diploma["departments"] as $key => $department) {
        $id = $department['id'];
        if ($id == null) {
            // Add new department
            $sql = "INSERT INTO deparments(name) VALUES ('" . $department['name'] . "')";
            $conn->query($sql);
            $id = $conn->lastInsertId();
            $diploma["departments"][$key]["id"] = $id;
        }
        array_push($attachedDepartmentIds, $id);

        // Check if department is already attached to diploma
        $sql = "SELECT * FROM diploma_has_deparments WHERE diploma_id = " . $diploma['id'] . " AND deparments_id = " . $id;
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // Attach department to diploma
            $sql = "INSERT INTO diploma_has_deparments(diploma_id, deparments_id) 
                    VALUES (" . $diploma["id"] . "," . $id . ")";
            $conn->query($sql);
        }
    }

    // Detach department
    if (sizeof($attachedDepartmentIds) > 0) {
        $sql = "DELETE FROM diploma_has_deparments WHERE diploma_id = " . $diploma['id'] . " AND deparments_id NOT IN(" . implode(",", $attachedDepartmentIds) . ")";
        $conn->query($sql);
    }
}

function saveTags($conn, &$diploma)
{
    $attachedTagIds = [];
    // Create and department
    foreach ($diploma["tags"] as $key => $tag) {
        $id = $tag['id'];
        if ($id == null) {
            // Add new tag
            $sql = "INSERT INTO tags(name) VALUES ('" . $tag['name'] . "')";
            $conn->query($sql);
            $id = $conn->lastInsertId();
            $diploma["tags"][$key]["id"] = $id;
        }
        array_push($attachedTagIds, $id);

        // Check if tag is already attached to diploma
        $sql = "SELECT * FROM diploma_has_tags WHERE diploma_id = " . $diploma['id'] . " AND tags_id = " . $id;
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            // Attach tag to diploma
            $sql = "INSERT INTO diploma_has_tags(diploma_id, tags_id) 
                    VALUES (" . $diploma["id"] . "," . $id . ")";
            $conn->query($sql);
        }
    }

    // Detach tag
    if (sizeof($attachedTagIds) > 0) {
        $sql = "DELETE FROM diploma_has_tags WHERE diploma_id = " . $diploma['id'] . " AND tags_id NOT IN(" . implode(",", $attachedTagIds) . ")";
        $conn->query($sql);
    }
}

function saveFile(&$diploma, $fileName, $tmp_name, $attachment)
{
    // Create upload directory if not available
    $uploads_dir = '../uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir);
    }

    // Get name of file
    $diploma_file_name = $fileName;

    // Get temporary name of file used for storage
    $orig_tmp_name = $tmp_name;

    // Combine temporary name of file with extension of original file name
    $diploma_file_tmp_name = basename($tmp_name);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $diploma_file_tmp_name = "{$diploma_file_tmp_name}.{$ext}";

    // Rename uploaded file for storage
    move_uploaded_file($orig_tmp_name, "$uploads_dir/$diploma_file_tmp_name");

    // Add file names in diploma object
    if ($attachment) {
        $diploma["attachments"][] = array("id" => NULL, "name" => $diploma_file_name, "tmp_name" => "$uploads_dir/$diploma_file_tmp_name");
    } else {
        $diploma["upload"] = array("name" => $diploma_file_name, "tmp_name" => "$uploads_dir/$diploma_file_tmp_name");
    }
}

function saveDiplomaFile(&$diploma)
{
    if (array_key_exists("diplomaFile", $_FILES)) {
        if ($_FILES["diplomaFile"]["error"] == UPLOAD_ERR_OK) {
            saveFile($diploma, $_FILES["diplomaFile"]["name"], $_FILES["diplomaFile"]["tmp_name"], false);
        } else {
            $error = $_FILES["diplomaFile"]["error"];
            die("Fehler beim Upload der Diplomarbeit. \nErrorcode für das Filearray: '$error'"); // FIXME
        }
    }
}

function saveAttachmentsFiles(&$diploma)
{
    if (array_key_exists("attachments", $_FILES)) { //Attachments einfügen, zuerst geprüft ob es ein attachment gibt
        foreach ($_FILES["attachments"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                saveFile($diploma, $_FILES["attachments"]["name"][$key], $_FILES["attachments"]["tmp_name"][$key], true);
            } else {
                $error = $_FILES["diplomaFile"]["error"];
                die("Fehler beim Upload des Anhangs. \nErrorcode für das Filearray: '$error'"); // FIXME
            }
        }
    }
}

Flight::start();
?>