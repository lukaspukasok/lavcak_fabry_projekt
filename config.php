<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "root";
$dbName = "todo_app";
$dbPort = 3306;

$conn = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
if (!$conn) {
    die(
        "Nepodarilo sa pripojit k databaze '$dbName'. " .
        "Najprv manualne vytvor databazu a importuj database.sql. " .
        "Detail: " . mysqli_connect_error()
    );
}

?>
