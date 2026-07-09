<?php
// menu.php
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

// Detectamos la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">MiGestor</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                
                <?php if ($pagina_actual === 'index.php' || $pagina_actual === 'logs_view.php'): ?>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm my-1 me-2" href="tareas.php?accion=consultar">Gestionar Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?php echo (isset($_GET['accion']) && $_GET['accion'] === 'crear') ? 'text-primary' : ''; ?>" href="tareas.php?accion=crear">Crear</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?php echo (isset($_GET['accion']) && $_GET['accion'] === 'consultar') ? 'text-primary' : ''; ?>" href="tareas.php?accion=consultar">Consultar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?php echo (isset($_GET['accion']) && $_GET['accion'] === 'modificar') ? 'text-primary' : ''; ?>" href="tareas.php?accion=modificar">Modificar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?php echo (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') ? 'text-primary' : ''; ?>" href="tareas.php?accion=eliminar">Eliminar</a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo ($pagina_actual === 'logs_view.php') ? 'text-primary fw-bold' : 'text-muted'; ?>" href="logs_view.php">Auditoría</a>
                </li>
            </ul>
            
            <div class="navbar-nav align-items-center">
                <span class="navbar-text me-3 mb-2 mb-lg-0">
                    Hola, <strong><?php echo $username; ?></strong>
                </span>
                <a class="btn btn-outline-danger btn-sm" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>