<?php
require_once(__DIR__ . "/config.php");

if (!isset($_COOKIE["logged"]) || $_COOKIE["logged"] !== "1") {
    header("Location: login.php");
    exit();
}

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$message = "";

if ($id <= 0) {
    header("Location: tasks.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT id, title FROM tasks WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$task = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($stmt);

if (!$task) {
    header("Location: tasks.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"] ?? "");

    if ($title === "") {
        $message = "Zadaj názov úlohy!";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE tasks SET title = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $title, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: tasks.php");
        exit();

        $stmt = mysqli_prepare($conn, "UPDATE tasks SET title = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $title, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: tasks.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upraviť úlohu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Upraviť úlohu</h1>

<?php if ($message): ?>
    <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
    <button type="submit">Uložiť</button>
</form>

<br>
<a href="tasks.php">Späť</a>

</body>
</html>