<?php
require_once("../config/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Úlohy</title>
</head>
<body>

<h1>Zoznam úloh</h1>

<a href="add.php">+ Pridať úlohu</a>
<br><br>

<?php
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<p>";
    echo $row["title"] . " (" . $row["status"] . ")";
    echo "</p>";
}
?>

</body>
</html>