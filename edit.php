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
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upraviť úlohu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-3">Upraviť úlohu</h3>

        <?php if ($message): ?>
            <div class="alert alert-danger p-2 text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Názov úlohy</label>
                <input
                    type="text"
                    id="title"
                    class="form-control"
                    name="title"
                    value="<?php echo htmlspecialchars($task['title']); ?>"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Uložiť</button>
        </form>

        <div class="text-center mt-3">
            <a href="tasks.php">Späť na úlohy</a>
        </div>
    </div>
</div>

</body>
</html>