<?php
// editar.php
require_once 'auth.php'; // Protege la página
$db = require_once 'db.php';

$tarea = null;

// Buscamos la tarea verificando que pertenezca al usuario
if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM tareas WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si la tarea no existe o no pertenece al usuario, redirigimos
if (!$tarea) {
    header('Location: index.php');
    exit();
}

// Si el usuario guarda cambios
if (isset($_POST['actualizar'])) {
    $stmt = $db->prepare("UPDATE tareas SET nombre = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$_POST['nombre'], $_POST['id'], $_SESSION['user_id']]);
    header('Location: tareas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tarea</title>
</head>
<body class="container mt-5">
    <?php include 'menu.php'; ?> <!-- Aquí lo agregas -->

    <h2>Editar Tarea</h2>

    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $tarea['id']; ?>">
        <div class="mb-3">
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($tarea['nombre']); ?>" required>
        </div>
        <button type="submit" name="actualizar" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>