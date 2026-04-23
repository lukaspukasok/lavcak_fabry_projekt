<?php
session_start();

if (isset($_COOKIE['logged']) && $_COOKIE['logged'] === '1' && isset($_SESSION['logged']) && $_SESSION['logged'] === '1') {
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
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light app-landing">
    <div class="container py-5 py-lg-6">
        <section class="hero-panel card border-0">
            <div class="card-body p-4 p-md-5 p-lg-6">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-7">
                        <p class="hero-kicker mb-2">Task Flow</p>
                        <h1 class="display-5 mb-3">Tvoje úlohy, čistá hlava, jasný systém.</h1>
                        <p class="text-muted mb-4">
                            Minimalistická appka na denné plánovanie. Prihlás sa, pridávaj úlohy, dokončuj ich a maj prehľad.
                        </p>
                        <nav class="d-flex flex-wrap gap-2">
                            <a class="btn btn-primary btn-lg" href="login.php">Prihlásiť sa</a>
                            <a class="btn btn-outline-primary btn-lg" href="register.php">Vytvoriť účet</a>
                        </nav>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="hero-card card shadow-sm border-0">
                            <div class="card-body p-4">
                                <p class="text-uppercase text-primary fw-semibold mb-2">Prečo to funguje</p>
                                <ul class="feature-list mb-0">
                                    <li>rýchle pridanie úloh bez bordelu</li>
                                    <li>jedno kliknutie na hotovo / späť</li>
                                    <li>prehľadný dashboard všetkých taskov</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>