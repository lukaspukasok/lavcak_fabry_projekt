<?php
require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    setcookie("logged", "", time() - 3600, "/");
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["toggle_status_id"])) {
    $taskId = (int) $_POST["toggle_status_id"];
    $currentStatus = $_POST["current_status"] ?? "pending";
    $newStatus = $currentStatus === "done" ? "pending" : "done";

    if ($taskId > 0) {
        $stmt = mysqli_prepare($conn, "UPDATE tasks SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $taskId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: tasks.php");
    exit();
}

$tasks = [];
$result = mysqli_query($conn, "SELECT id, title, status FROM tasks ORDER BY id DESC");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Úlohy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">Zoznam úloh</h1>
                    <p class="text-muted mb-0">Úlohy, pridanie, edit a delete sú rozdelené do samostatných súborov.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="add.php" class="btn btn-primary">+ Pridať úlohu</a>
                    <a href="index.php" class="btn btn-outline-secondary">Späť</a>
                    <form method="post" class="d-inline">
                        <button type="submit" name="logout" class="btn btn-outline-danger">Odhlásiť sa</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if (!$tasks): ?>
                        <p class="mb-0 text-muted">Zatiaľ tu nie sú žiadne úlohy.</p>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($tasks as $task): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <div class="fw-semibold <?php echo $task["status"] === "done" ? "text-decoration-line-through text-muted" : ""; ?>">
                                            <?php echo htmlspecialchars($task["title"]); ?>
                                        </div>
                                        <small class="text-muted">Stav: <?php echo htmlspecialchars($task["status"]); ?></small>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="toggle_status_id" value="<?php echo (int) $task["id"]; ?>">
                                            <input type="hidden" name="current_status" value="<?php echo htmlspecialchars($task["status"]); ?>">
                                            <button type="submit" class="btn btn-sm <?php echo $task["status"] === "done" ? "btn-outline-warning" : "btn-success"; ?>">
                                                <?php echo $task["status"] === "done" ? "Undone" : "Done"; ?>
                                            </button>
                                        </form>
                                        <a href="edit.php?id=<?php echo (int) $task["id"]; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="delete.php?id=<?php echo (int) $task["id"]; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Naozaj chceš úlohu vymazať?');">Delete</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>