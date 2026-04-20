<?php
session_start();
require_once __DIR__ . '/config.php';

$message = "";

if (isset($_POST["login"])) {
    $userForm = trim($_POST["username"] ?? "");
    $passForm = $_POST["password"] ?? "";

    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $userForm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    if ($row) {
        if (password_verify($passForm, $row["password"])) {
            setcookie("logged", "1", time() + 3600, "/");
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_id"] = (int) $row["id"];
            header("Location: tasks.php");
            exit;
        } else {
            $message = "Nesprávne heslo!";
        }
    } else {
        $message = "Používateľ neexistuje!";
    }
}

if (isset($_POST["logout"])) {
    setcookie("logged", "", time() - 3600, "/");
    unset($_SESSION["username"], $_SESSION["user_id"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$is_logged = isset($_COOKIE["logged"]);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<title>Login s Databázou</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
<div class="card shadow p-4" style="max-width: 400px; width: 100%;">
<h3 class="text-center mb-3">Prihlásenie (DB)</h3>

<?php if ($is_logged): ?>

<div class="alert alert-success text-center">Používateľ je prihlásený ✅</div>

<form method="post">
<button type="submit" name="logout" class="btn btn-danger w-100">Odhlásiť sa</button>
</form>

<?php else: ?>

<?php if ($message): ?>
<div class="alert alert-danger p-2 text-center"><?php echo $message; ?></div>
<?php endif; ?>

<form method="post">
<div class="mb-3">
<label class="form-label">Používateľské meno</label>
<input type="text" class="form-control" name="username" required>
</div>

<div class="mb-3">
<label class="form-label">Heslo</label>
<input type="password" class="form-control" name="password" required>
</div>

<button type="submit" name="login" class="btn btn-primary w-100">Prihlásiť sa</button>

<div class="text-center mt-2">
<a href="reset_password.php">Zabudol si heslo?</a>
</div>

<div class="text-center mt-3">
<a href="register.php">Zaregistruj sa</a>
</div>

</form>

<?php endif; ?>

</div>
   <?php include "footer.php"; ?>
</div>


</body>
</html>