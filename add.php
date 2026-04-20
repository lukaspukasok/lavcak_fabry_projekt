<?php
require_once(__DIR__ . "/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"] ?? "");

    if (!empty($title)) {
        $status = "pending";
        $stmt = mysqli_prepare($conn, "INSERT INTO tasks (title, status) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $title, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: tasks.php");
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
<a href="tasks.php">Späť</a>

</body>
</html>