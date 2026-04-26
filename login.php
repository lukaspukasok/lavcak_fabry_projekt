<?php
session_start();
include "config.php";

$message = "";

// LOGIN
if (isset($_POST["login"])) {
  $username = mysqli_real_escape_string($conn, trim($_POST["username"] ?? ""));
  $password = $_POST["password"] ?? "";

  $sql = "SELECT * FROM users WHERE username = '$username' ORDER BY id ASC";
  $result = mysqli_query($conn, $sql);

  $authenticatedUser = null;
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $authenticatedUser = $row;
        break;
      }
    }
  }

  if ($authenticatedUser) {
      setcookie("logged", "1", time() + 3600, "/");
      $_SESSION["logged"] = "1";
      $_SESSION["username"] = $authenticatedUser["username"];
      $_SESSION["user_id"] = $authenticatedUser["id"];
      header("Location: " . "/lavcak_fabry_projekt/tasks.php");
      exit();
  } else {
    $message = "Nesprávne používateľské meno alebo heslo.";
  }
}

// LOGOUT
if (isset($_POST["logout"])) {
  setcookie("logged", "", time() - 3600, "/");
  unset($_SESSION["logged"], $_SESSION["username"], $_SESSION["user_id"]);
  session_destroy();
  header("Location: " . "/lavcak_fabry_projekt/index.php");
  exit();
}

$isLogged = isset($_COOKIE["logged"]) && $_COOKIE["logged"] === "1"
  && isset($_SESSION["logged"]) && $_SESSION["logged"] === "1";
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie stránka - Cookies úloha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    
    <h3 class="text-center mb-3">Prihlásenie používateľa</h3>
    <p class="text-muted text-center">Použitie cookies</p>

    <?php if (!$isLogged){ ?>

      <?php if ($message): ?>
        <div class="alert alert-danger text-center mb-3"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>
      
      <!-- LOGIN FORM -->
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Používateľské meno</label>
          <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Heslo</label>
          <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">
          Prihlásiť sa
        </button>
      </form>

    <?php }else{ ?>

      <!-- LOGOUT -->
      <form method="post">
        <button type="submit" name="logout" class="btn btn-outline-danger w-100">
          Odhlásiť sa
        </button>
      </form>

    <?php } ?>

    <hr class="my-3">

    <!-- STATUS -->
    <div class="text-center">
      <?php
      if ($isLogged) {
        echo "Používateľ je prihlásený.";
      } else {
        echo "<a href='register.php'>Registrovať sa </a>";
        echo "<a href='reset_password.php'>Zabudnuté heslo</a>";
      }
      ?>
    </div>


  </div>
</div>

</body>
</html>