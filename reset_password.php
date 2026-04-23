<?php
include "config.php";

$message = "";

if (isset($_POST["reset"])) {

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $newPassword = $_POST["new_password"];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");

    if (mysqli_num_rows($check) == 1) {               

        $sql = "UPDATE users SET password='$hashedPassword' WHERE username='$username'";

        if (mysqli_query($conn, $sql)) {
            $message = "Heslo bolo úspešne zmenené ✅";
        } else {
            $message = "Chyba pri zmene hesla ❌";
        }

    } else {
        $message = "Používateľ neexistuje ❌";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<title>Obnovenie hesla</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
<div class="card shadow p-4" style="max-width: 400px; width: 100%;">

<h3 class="text-center mb-3">Zabudnuté heslo</h3>

<?php if ($message): ?>
<div class="alert alert-info text-center"><?php echo $message; ?></div>
<?php endif; ?>

<form method="post">

<div class="mb-3">
<label class="form-label">Používateľské meno</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Nové heslo</label>
<input type="password" name="new_password" class="form-control" required>
</div>

<button type="submit" name="reset" class="btn btn-primary w-100">
Zmeniť heslo
</button>

</form>

<hr class="my-3">

<div class="text-center">
<form action="login.php" method="get">
<button type="submit" class="btn btn-link p-0">Späť na prihlásenie</button>
</form>
</div>

</div>
</div>

</body>
</html>
