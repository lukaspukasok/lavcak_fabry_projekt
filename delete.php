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

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: /lavcak_fabry_projekt/tasks.php");
exit();