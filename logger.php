<?php
// logger.php

function registrarLog($db, $evento, $detalle = "") {
    global $db; 
    
    // Forzamos a PHP a usar la zona horaria oficial de Chile Continental
    date_default_timezone_set('America/Santiago');
    $hora_local = date('Y-m-d H:i:s'); // Captura la fecha y hora exacta de Chile (ej: 09:35:00)
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $user_id = $_SESSION['user_id'] ?? null;
    
    // Detección de IP Real compatible con Codespaces
    $ip = '127.0.0.1';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    try {
        // Modificamos el INSERT para meter manualmente la hora local de Chile ($hora_local)
        $stmt = $db->prepare("INSERT INTO logs (fecha_hora, usuario_id, evento, detalle, ip_host_client) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$hora_local, $user_id, $evento, $detalle, $ip]);
    } catch (Exception $e) {
        error_log("Error crítico en registrarLog: " . $e->getMessage());
    }
}
?>