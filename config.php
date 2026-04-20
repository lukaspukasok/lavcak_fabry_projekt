<?php

$conn = mysqli("localhost", "root", "", "todo_app");

if (!$conn) {
    die("Chyba pripojenia: " . mysqli_connect_error());
}

else {
    echo "Pripojenie bolo úspešné!";
}

?>
