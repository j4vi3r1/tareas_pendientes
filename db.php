<?php
// db.php
try {
    $db = new PDO('sqlite:tareas.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS tareas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        estado TEXT DEFAULT 'pendiente'
    )");
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
?>