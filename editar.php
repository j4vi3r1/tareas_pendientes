<?php
// editar.php
require_once 'auth.php'; // Protege la página
$db = require_once 'db.php';
require_once 'logger.php'; // Importamos el sistema de logs

$tarea = null;

// Buscamos la tarea verificando que pertenezca al usuario
if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM tareas WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si la tarea no existe o no pertenece al usuario, redirigimos
if (!$tarea) {
    header('Location: tareas.php');
    exit();
}

// Si el usuario guarda cambios
if (isset($_POST['actualizar'])) {
    $nuevo_nombre = trim($_POST['nombre']);
    $id = $_POST['id'];

    if (!empty($nuevo_nombre)) {
        $stmt = $db->prepare("UPDATE tareas SET nombre = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$nuevo_nombre, $id, $_SESSION['user_id']]);
        
        // Log: Modificar registro (Tipo 5)
        registrarLog($db, "modificar registro", "Tarea ID $id renombrada a: " . $nuevo_nombre);
        
        header('Location: tareas.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tarea</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php include 'menu.php'; ?>

        <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Editar Tarea</h2>

            <form action="editar.php?id=<?php echo $tarea['id']; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $tarea['id']; ?>">
                
                <div class="mb-3">
                    <label class="form-label">Nombre de la tarea</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($tarea['nombre']); ?>" required>
                </div>
                
                <button type="submit" name="actualizar" class="btn btn-primary">Guardar Cambios</button>
                <a href="tareas.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>