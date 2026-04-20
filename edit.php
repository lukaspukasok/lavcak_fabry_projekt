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

$stmt = mysqli_prepare($conn, "SELECT id, title, status FROM tasks WHERE id = ? LIMIT 1");
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
    $status = $_POST["status"] ?? "pending";

    if ($title === "") {
        $message = "Zadaj názov úlohy!";
    } else {
        if (!in_array($status, ["pending", "done"], true)) {
            $status = "pending";
        }

        $stmt = mysqli_prepare($conn, "UPDATE tasks SET title = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $title, $status, $id);
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