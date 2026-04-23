<!DOCTYPE html>
<html lang="sk">

  <?php 
  require_once __DIR__ . "/config.php";
  include "parts/header.php" 
  ?>

<head>
  <meta charset="UTF-8">
  <title>Registrácia stránka - Cookies úloha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">

      <h3 class="text-center mb-3">Resetovať heslo používateľa</h3>

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
        <a href="register.php">Registrovať sa</a>
        <a href="login.php">Prihlásiť sa</a>
      </div>

    </div>
  </div>

</body>

</html>