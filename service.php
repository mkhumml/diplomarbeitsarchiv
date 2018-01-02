<?php
$foo = file_get_contents("php://input");
$person = json_decode($foo, true);
echo $person["firstName"];
?>