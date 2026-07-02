<?php
// index.php
session_start();
$db = require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php if(isset($_SESSION['user_id'])): 
        // --- VISTA PARA USUARIO LOGUEADO (DASHBOARD) ---
        include 'menu.php'; ?>
        
        <div class="container mt-4">
            <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
                <h1 class="display-5 fw-bold">¡Hola de nuevo! 👋</h1>
                <p class="fs-4 text-muted">Aquí tienes un resumen de tu actividad:</p>
                
                <div class="row mt-4 g-3">
                    <div class="col-md-6">
                        <div class="card border-primary shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Tareas Pendientes</h5>
                                <?php 
                                    $stmt = $db->prepare("SELECT COUNT(*) FROM tareas WHERE user_id = ? AND estado = 'pendiente'");
                                    $stmt->execute([$_SESSION['user_id']]);
                                    echo "<h2 class='display-4'>".$stmt->fetchColumn()."</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-success shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-success">Tareas Realizadas</h5>
                                <?php 
                                    $stmt = $db->prepare("SELECT COUNT(*) FROM tareas WHERE user_id = ? AND estado = 'completada'");
                                    $stmt->execute([$_SESSION['user_id']]);
                                    echo "<h2 class='display-4'>".$stmt->fetchColumn()."</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="tareas.php" class="btn btn-primary btn-lg">Ir a gestionar mis tareas</a>
                </div>
            </div>
        </div>

    <?php else: 
        // --- VISTA PARA INVITADO (BIENVENIDA) --- ?>
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="text-center p-5 bg-white shadow rounded" style="max-width: 500px; width: 100%;">
                <h1 class="display-4 fw-bold text-primary">Gestor de Tareas</h1>
                <p class="lead mt-3">Organiza tu vida de forma eficiente y segura.</p>
                <hr class="my-4">
                <div class="d-grid gap-2">
                    <a href="login.php" class="btn btn-success btn-lg">Iniciar Sesión</a>
                    <a href="registro.php" class="btn btn-outline-primary btn-lg">Crear una cuenta</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>