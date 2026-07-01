<?php
// db.php
try {
    $db = new PDO('sqlite:tareas.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tabla de usuarios
    $db->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    )");

    // Tabla de tareas con columna user_id
    $db->exec("CREATE TABLE IF NOT EXISTS tareas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        estado TEXT DEFAULT 'pendiente',
        user_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES usuarios(id)
    )");

    return $db;
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
?>