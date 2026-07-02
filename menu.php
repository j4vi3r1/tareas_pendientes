<?php
// menu.php
// Usamos la variable $db que viene del archivo principal (index.php o tareas.php)
// Si no existe, la inicializamos
if (!isset($db)) {
    $db = require_once 'db.php';
}

$username = "Usuario";
if (isset($_SESSION['user_id'])) {
    $stmt = $db->prepare("SELECT username FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $username = htmlspecialchars($user['username']);
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">MiGestor</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tareas.php">Mis Tareas</a>
                </li>
            </ul>
            
            <div class="navbar-nav">
                <span class="navbar-text me-3">
                    Hola, <strong><?php echo $username; ?></strong>
                </span>
                <a class="btn btn-outline-danger btn-sm" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>