<?php

$message = "";

if (isset($_POST["login"])) {

    $userForm = mysqli_real_escape_string($con, $_POST["username"]);
    $passForm = mysqli_real_escape_string($con, $_POST["password"]);

    $sql = "SELECT * FROM user WHERE meno='$userForm' LIMIT 1";
    $result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($passForm, $row["heslo"])) {
        setcookie("logged", "1", time() + 3600, "/");
        header("Location: " . $_SERVER['PHP_SELF']);
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
<a href="forgot_password.php">Zabudol si heslo?</a>
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