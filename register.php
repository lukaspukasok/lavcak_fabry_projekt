<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/config.php';

$message = "";

if (isset($_POST["register"])) {
  $username = trim($_POST["username"] ?? "");
  $plainPassword = $_POST["password"] ?? "";

  if ($username === "" || $plainPassword === "") {
    $message = "Vyplň používateľské meno aj heslo.";
  } else {
    $username = mysqli_real_escape_string($conn, $username);
    $password = password_hash($plainPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    try {
      if (mysqli_query($conn, $sql)) {
        $userId = mysqli_insert_id($conn);

        setcookie("logged", "1", time() + 3600, "/");
        $_SESSION["logged"] = "1";
        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $userId;
        header("Location: /lavcak_fabry_projekt/tasks.php");
        exit;
      } else {
        $message = "Chyba pri registrácii: " . mysqli_error($conn);
      }
    } catch (mysqli_sql_exception $e) {
      if ((int)$e->getCode() === 1062) {
        $message = "Používateľské meno už existuje. Zvoľ iné.";
      } else {
        $message = "Chyba pri registrácii: " . $e->getMessage();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrácia stránka - Cookies úloha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    
    <h3 class="text-center mb-3">Registrácia používateľa</h3>

      <?php if ($message): ?>
        <div class="alert alert-warning py-2" role="alert"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>
      
      <!-- REGISTER FORM -->
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Používateľské meno</label>
          <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Heslo</label>
          <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" name="register" class="btn btn-primary w-100">
          Registrovať sa
        </button>
      </form>

    <hr class="my-3">

    <div class="text-center">
      <a href="login.php">Už máte účet? Prihláste sa</a>
    </div>

  </div>
</div>

</body>
</html>