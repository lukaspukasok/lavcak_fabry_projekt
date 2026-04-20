<?php
require_once(__DIR__ . "/config.php");

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id > 0) {
	$stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

header("Location: tasks.php");
exit();