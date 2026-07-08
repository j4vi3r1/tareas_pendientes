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
        password TEXT NOT NULL,
        verificado INTEGER DEFAULT 0,
        token TEXT
    )");

    // Tabla de tareas con columna user_id
    $db->exec("CREATE TABLE IF NOT EXISTS tareas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        estado TEXT DEFAULT 'pendiente',
        user_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES usuarios(id)
    )");

    // Tabla de logs
    $db->exec("CREATE TABLE IF NOT EXISTS logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_id INTEGER,
    evento TEXT NOT NULL,
    detalle TEXT,
    ip_host_client TEXT
    )");

    return $db;
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
?>