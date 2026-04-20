<!DOCTYPE html>
<html lang="sk">

<?php include "parts/header.php" ?>

<body class="bg-light">
  <?php include "parts/db_connect.php" ?>
<?php

// LOGIN
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"]; 

  $sql = "SELECT * FROM user WHERE name = '$username'";
  $result = mysqli_query($conn, $sql);

  $hash_password = mysqli_fetch_assoc($result);

  if(mysqli_num_rows($result) == 1){
    if(password_verify($password,  $hash_password['password'])){
      setcookie("logged", "1", time() + 3600);
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }
  }
}

// LOGOUT
if (isset($_POST["logout"])) {
  setcookie("logged", "", time() - 3600);
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    
    <h3 class="text-center mb-3">Prihlásenie používateľa</h3>
    <p class="text-muted text-center">Použitie cookies</p>

    <?php if (!isset($_COOKIE["logged"])){ ?>
      
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
      if (isset($_COOKIE["logged"])) {
        echo "Používateľ je prihlásený.";
      } else {
        echo "<a href='register.php'>Registrovať sa </a>";
        echo "<a href='forgot_password.php'>Zabudnuté heslo</a>";
      }
      ?>
    </div>

    <?php include "parts/footer.php"; ?>

  </div>
</div>

</body>
</html>