<?php
// process.php
require_once 'auth.php'; // Verifica que el usuario tenga sesión iniciada
$db = require_once 'db.php';
require_once 'logger.php'; // Incluimos la función de logs

// Acción: Agregar nueva tarea
if (isset($_POST['agregar'])) {
    $nombre = trim($_POST['nombre']);
    if (!empty($nombre)) {
        $stmt = $db->prepare("INSERT INTO tareas (nombre, user_id) VALUES (?, ?)");
        $stmt->execute([$nombre, $_SESSION['user_id']]);
        
        // Log: Crear registro
        registrarLog($db, "crear registro", "Tarea creada: " . $nombre);
    }
    header('Location: tareas.php');
    exit();
}

// Acción: Eliminar tarea
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    // Ejecutamos el borrado
    $stmt = $db->prepare("DELETE FROM tareas WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    
    // Log: Eliminar registro
    registrarLog($db, "eliminar registro", "Tarea eliminada con ID: " . $id);
    
    header('Location: tareas.php');
    exit();
}

// Acción: Cambiar estado (Completar / Desmarcar)
if (isset($_GET['cambiar_estado'])) {
    $id = $_GET['cambiar_estado'];
    $estado_actual = $_GET['estado'];
    $nuevo_estado = ($estado_actual == 'pendiente') ? 'completada' : 'pendiente';
    
    $stmt = $db->prepare("UPDATE tareas SET estado = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$nuevo_estado, $id, $_SESSION['user_id']]);
    
    // Log: Modificar registro
    registrarLog($db, "modificar registro", "Tarea ID $id cambiada a: $nuevo_estado");
    
    header('Location: tareas.php');
    exit();
}
?>