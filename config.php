<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prvé pripojenie bez databázy
$conn_init = mysqli_connect("localhost", "root", "root", "", 3306);

if (!$conn_init) {
    die("Chyba pripojenia: " . mysqli_connect_error());
}

// Vytvor databázu ak neexistuje
$sql = "CREATE DATABASE IF NOT EXISTS todo_app";
if (!mysqli_query($conn_init, $sql)) {
    die("Chyba pri vytváraní databázy: " . mysqli_error($conn_init));
}

mysqli_close($conn_init);

// Teraz prihlás sa s databázou
$conn = mysqli_connect("localhost", "root", "root", "todo_app", 3306);

if (!$conn) {
    die("Chyba pripojenia: " . mysqli_connect_error());
}

// Vytvor tabuľku users
$sql = "CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!mysqli_query($conn, $sql)) {
    die("Chyba pri vytváraní tabuľky users: " . mysqli_error($conn));
}

// Uisti sa, že username má UNIQUE index.
$duplicateCheckSql = "SELECT username, COUNT(*) AS cnt FROM users GROUP BY username HAVING cnt > 1 LIMIT 1";
$duplicateCheckResult = mysqli_query($conn, $duplicateCheckSql);
if ($duplicateCheckResult && mysqli_num_rows($duplicateCheckResult) > 0) {
    die("V databáze sú duplicitné používateľské mená. Odstráň duplicity a potom obnov stránku.");
}

$uniqueIndexQuery = "SELECT INDEX_NAME FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = 'todo_app'
      AND TABLE_NAME = 'users'
      AND COLUMN_NAME = 'username'
      AND NON_UNIQUE = 0
      AND INDEX_NAME <> 'PRIMARY'
    LIMIT 1";
$uniqueIndexResult = mysqli_query($conn, $uniqueIndexQuery);
if (!$uniqueIndexResult || mysqli_num_rows($uniqueIndexResult) === 0) {
    $addUniqueSql = "ALTER TABLE users ADD UNIQUE INDEX users_username_unique (username)";
    if (!mysqli_query($conn, $addUniqueSql)) {
        die("Chyba pri vytváraní UNIQUE indexu username: " . mysqli_error($conn));
    }
}

// Vytvor tabuľku tasks
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'done') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if (!mysqli_query($conn, $sql)) {
    die("Chyba pri vytváraní tabuľky tasks: " . mysqli_error($conn));
}

?>
