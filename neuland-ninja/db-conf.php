<?php
$dbData = array(
    'host'  =>  'localhost',
    'user'  =>  'ninja',
    'pass'  =>  '1nDpWKqJybC2pd8U',
    'db'    =>  'ninjaDB'
);

$mysqli = new mysqli($dbData['host'], $dbData['user'], $dbData['pass'], $dbData['db']);
if ($mysqli->connect_errno) die('Datenbankverbindung fehlgeschlagen, wende dich an den Administrator! ('.$mysqli->connect_error.')');
?>
