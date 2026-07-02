<?php
// process.php
require_once 'auth.php'; // Protege el archivo y verifica la sesión
$db = require_once 'db.php';

// Acción: Agregar
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    // Insertamos incluyendo el user_id para asociar la tarea al usuario
    $stmt = $db->prepare("INSERT INTO tareas (nombre, user_id) VALUES (?, ?)");
    $stmt->execute([$nombre, $_SESSION['user_id']]);
    header('Location: tareas.php');
    exit();
}

// Acción: Eliminar
// Se verifica el user_id para asegurar que el usuario solo borre SUS tareas
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $db->prepare("DELETE FROM tareas WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header('Location: tareas.php');
    exit();
}

// Acción: Cambiar estado
// Se verifica el user_id para asegurar que el usuario solo modifique SUS tareas
if (isset($_GET['cambiar_estado'])) {
    $id = $_GET['cambiar_estado'];
    $estado_actual = $_GET['estado'];
    $nuevo_estado = ($estado_actual == 'pendiente') ? 'completada' : 'pendiente';
    
    $stmt = $db->prepare("UPDATE tareas SET estado = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$nuevo_estado, $id, $_SESSION['user_id']]);
    header('Location: tareas.php');
    exit();
}
?>