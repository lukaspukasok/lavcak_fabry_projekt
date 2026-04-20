<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <title>Registrácia stránka - Cookies úloha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php
  $conn = mysqli_connect("localhost", "root", "root", "aut");

  if(!$conn){
    echo "Chyba pripojenia" . mysqli_connect_error();
  }

  if(isset($_POST["register"])){
  $username = $_POST["username"];
  $password = ($_POST["password"]);

  $sql = "INSERT INTO user (meno, heslo) VALUES ('$username', '$password')";

  if(mysqli_query($conn, $sql)){
      setcookie("logged", "1", time() + 3600, "/");
      header("Location: 17auth.php");
      exit;
  }
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
    
    <h3 class="text-center mb-3">Registrácia používateľa</h3>
      
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
      <a href="17auth.php">Už máte účet? Prihláste sa</a>
    </div>

  </div>
</div>

</body>
</html>