<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost","root","root","todo_app", 3306);

if (!$conn) {
    die(
        "Nepodarilo sa pripojit k databaze '$dbName'. " .
        "Najprv manualne vytvor databazu a importuj database.sql. " .
        "Detail: " . mysqli_connect_error()
    );
}

?>
