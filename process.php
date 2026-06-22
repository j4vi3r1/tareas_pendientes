<?php
$db = require_once 'db.php';

// Acción: Agregar
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $stmt = $db->prepare("INSERT INTO tareas (nombre) VALUES (?)");
    $stmt->execute([$nombre]);
    header('Location: index.php');
}

// Acción: Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $db->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
}

// Acción: Cambiar estado
if (isset($_GET['cambiar_estado'])) {
    $id = $_GET['cambiar_estado'];
    $estado_actual = $_GET['estado'];
    $nuevo_estado = ($estado_actual == 'pendiente') ? 'completada' : 'pendiente';
    
    $stmt = $db->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
    $stmt->execute([$nuevo_estado, $id]);
    header('Location: index.php');
}
?>