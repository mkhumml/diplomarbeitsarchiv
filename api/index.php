<?php
require 'flight/Flight.php';

$servername = "localhost"; //MySQL Daten
$user = "root";
$pw = "root";
$db = "diplomarbeitsarchiv";

Flight::route('GET /diplomarbeiten', function() {
    $arr1 = array('id' => 1, 'title' => "title1", 'author' => "author1", 'tutor' => "Sacher", 'department' => "Elektronik", 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => "summary1", 'attachments' => "attachments1", 'tags' => "tags1");
    $arr2 = array('id' => 2, 'title' => "title2", 'author' => "author2", 'tutor' => "Sacher", 'department' => "Informationstechnologie", 'year' => "jahr2", 'upload' => "diplomathesispdf2", 'summary' => "summary2", 'attachments' => "attachments2", 'tags' => "tags2");
    $arr3 = array('id' => 3, 'title' => "title3", 'author' => "author3", 'tutor' => "Loibner", 'department' => "Informationstechnologie", 'year' => "jahr3", 'upload' => "diplomathesispdf3", 'summary' => "summary3", 'attachments' => "attachments3", 'tags' => "tags3");
    $arr4 = array('id' => 4, 'title' => "title4", 'author' => "author4", 'tutor' => "Sacher", 'department' => "Informationstechnologie", 'year' => "jahr4", 'upload' => "diplomathesispdf4", 'summary' => "summary4", 'attachments' => "attachments4", 'tags' => "tags4");
    $arr5 = array('id' => 5, 'title' => "title5", 'author' => "author5", 'tutor' => "Loibner", 'department' => "Medientechnik", 'year' => "jahr5", 'upload' => "diplomathesispdf5", 'summary' => "summary5", 'attachments' => "attachments5", 'tags' => "tags5");
    $arr6 = array('id' => 6, 'title' => "title6", 'author' => "author6", 'tutor' => "Rybi", 'department' => "Medientechnik", 'year' => "jahr6", 'upload' => "diplomathesispdf6", 'summary' => "summary6", 'attachments' => "attachments6", 'tags' => "tags6");
    echo "[";
    echo json_encode($arr1);
    echo ",";
    echo json_encode($arr2);
    echo ",";
    echo json_encode($arr3);
    echo ",";
    echo json_encode($arr4);
    echo ",";
    echo json_encode($arr5);
    echo ",";
    echo json_encode($arr6);
    echo "]";
});


Flight::route('GET /diplomarbeiten/@id', function($id) {
    $arr1 = array('id' => $id, 'title' => "title1", 'author' => "author1", 'tutor' => "tutor1", 'department' => "department1", 'year' => "jahr1", 'upload' => "diplomathesispdf1", 'summary' => "summary1", 'attachments' => "attachments1", 'tags' => "tags1");
    echo json_encode($arr1);
});

Flight::route('DELETE /diplomarbeiten/@id', function($id) {
    echo "$id";
});

// Create or update diploma
Flight::route('POST /diplomarbeiten/', function() {
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

Flight::start();
?>