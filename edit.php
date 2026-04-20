<?php
require_once("../config/db.php");

$id = $_GET["id"];
$result = $conn->query("SELECT * FROM tasks WHERE id = $id");
$task = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $status = $_POST["status"];

    $sql = "UPDATE tasks SET title='$title', status='$status' WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upraviť úlohu</title>
</head>
<body>

<h1>Upraviť úlohu</h1>

<form method="POST">
    <input type="text" name="title" value="<?php echo $task['title']; ?>">
    
    <select name="status">
        <option value="pending" <?php if ($task['status']=="pending") echo "selected"; ?>>Pending</option>
        <option value="done" <?php if ($task['status']=="done") echo "selected"; ?>>Done</option>
    </select>

    <button type="submit">Uložiť</button>
</form>

<br>
<a href="index.php">Späť</a>

</body>
</html>