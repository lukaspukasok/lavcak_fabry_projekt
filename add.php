<?php
session_start();
require_once(__DIR__ . "/config.php");

if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "1") {
    header("Location: /lavcak_fabry_projekt/login.php");
    exit();
}

$userId = $_SESSION["user_id"] ?? null;
if (!$userId) {
    header("Location: /lavcak_fabry_projekt/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"] ?? "");

    if (!empty($title)) {
        $status = "pending";
        $stmt = mysqli_prepare($conn, "INSERT INTO tasks (user_id, title, status) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iss", $userId, $title, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: /lavcak_fabry_projekt/tasks.php");
        exit();
    } else {
        $message = "Zadaj názov úlohy!";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pridať úlohu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-3">Pridať úlohu</h3>

        <?php if ($message): ?>
            <div class="alert alert-danger p-2 text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Názov úlohy</label>
                <input type="text" id="title" class="form-control" name="title" placeholder="Názov úlohy" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Pridať</button>
        </form>

        <div class="text-center mt-3">
            <a href="tasks.php">Späť na úlohy</a>
        </div>
    </div>
</div>

</body>
</html>