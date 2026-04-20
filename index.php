<?php
session_start();

if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === '1') {
    header('Location: tasks.php');
    exit;
}

$username = $_SESSION['username'] ?? null;
?>
<!doctype html>
<html lang="sk">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="bg-light min-vh-100 d-flex align-items-center">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
          <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
              <p class="text-uppercase text-primary fw-semibold mb-2">Todo App</p>
              <h1 class="display-6 mb-3">Vitaj v Todo App</h1>

              <p class="text-muted mb-4">
                Tu sa vieš prihlásiť alebo zaregistrovať. Po prihlásení ťa aplikácia presunie do zoznamu úloh.
              </p>

            

              <nav class="d-flex flex-wrap gap-2">
                <a class="btn btn-primary" href="login.php">Login</a>
                <a class="btn btn-outline-primary" href="register.php">Register</a>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>