<?php
// index.php (Portal de Bienvenida)
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Gestor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Gestor de Tareas</a>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <h1 class="display-4">Bienvenido a tu Gestor de Tareas</h1>
        <p class="lead">Organiza tu día de forma eficiente y segura.</p>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="tareas.php" class="btn btn-primary btn-lg">Ir a mis tareas</a>
        <?php else: ?>
            <div class="mt-4">
                <a href="login.php" class="btn btn-success btn-lg">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-outline-primary btn-lg">Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>