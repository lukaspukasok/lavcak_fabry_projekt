<?php

$conn = mysqli_connect("localhost", "root", "root", "todo_app");

if (!$conn) {
    die("Chyba pripojenia: " . mysqli_connect_error());
}

?>
