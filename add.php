<?php
require_once(__DIR__ . "/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];

    if (!empty($title)) {
        $sql = "INSERT INTO tasks (title) VALUES ('$title')";
        $conn->query($sql);

        header("Location: index.php");
        exit();
    } else {
        echo "Zadaj názov úlohy!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pridať úlohu</title>
</head>
<body>

<h1>Pridať úlohu</h1>

<form method="POST">
    <input type="text" name="title" placeholder="Názov úlohy">
    <button type="submit">Pridať</button>
</form>

<br>
<a href="index.php">Späť</a>

</body>
</html>