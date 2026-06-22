<?php
$db = require_once 'db.php';

// Si recibimos un ID para editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM tareas WHERE id = ?");
    $stmt->execute([$id]);
    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si el usuario guardó los cambios
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $stmt = $db->prepare("UPDATE tareas SET nombre = ? WHERE id = ?");
    $stmt->execute([$nombre, $id]);
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tarea</title>
</head>
<body class="container mt-5">
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