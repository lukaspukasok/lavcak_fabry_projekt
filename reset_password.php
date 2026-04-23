<?php
require_once __DIR__ . "/config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["resetPassword"])) {
  $username = trim($_POST["username"] ?? "");
  $newPassword = $_POST["new_password"] ?? "";

  if ($username !== "" && $newPassword !== "") {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $message = "Heslo bolo úspešne zmenené.";
    } else {
      $message = "Používateľ sa nenašiel.";
    }

    mysqli_stmt_close($stmt);
  } else {
    $message = "Vyplň používateľské meno aj nové heslo.";
  }
}
?>

<!DOCTYPE html>
<html lang="sk">
  <head>
    <meta charset="UTF-8">
    <title>Prihlásenie stránka - Cookies úloha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>




<body class="bg-light">


  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">

      <h3 class="text-center mb-3">Resetovať heslo používateľa</h3>
      <p class="text-muted text-center">Použitie cookies</p>

      <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Používateľské meno</label>
          <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nové heslo</label>
          <input type="password" class="form-control" name="new_password" required>
        </div>

        <button type="submit" name="resetPassword" class="btn btn-primary w-100">
          Resetovať heslo
        </button>
      </form>

      <hr class="my-3">

      <div class="text-center">
        <a href="register.php">registrovať sa</a>
        <a href="login.php">Prihlásiť sa</a>
      </div>

    </div>
  </div>

</body>

</html>