<?php
// logger.php

function registrarLog($db, $evento, $detalle = "") {
    global $db; 
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $user_id = $_SESSION['user_id'] ?? null;
    
    // SISTEMA AVANZADO DE DETECCIÓN DE IP PARA CODESPACES / PROXIES
    $ip = '127.0.0.1'; // IP por defecto si todo falla

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // En entornos de la nube, viene una lista de IPs separadas por coma.
        // La primera de la izquierda es SIEMPRE la IP real del cliente.
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        // Alternativa común usada por algunos balanceadores de carga
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Otra cabecera estándar de proveedores de internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        // Conexión directa tradicional
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    // --- LÍNEA OPCIONAL PARA TU DEBUG DE TEXTO (Puedes mantenerla o borrarla) ---
    $fecha = date('Y-m-d H:i:s');
    $mensaje_txt = "[$fecha] Usuario ID: " . ($user_id ?? 'Invitado') . " | Evento: $evento | Detalle: $detalle | IP Real Detectada: $ip\n";
    file_put_contents('debug.txt', $mensaje_txt, FILE_APPEND);
    // ---------------------------------------------------------------------------

    try {
        $stmt = $db->prepare("INSERT INTO logs (usuario_id, evento, detalle, ip_host_client) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $evento, $detalle, $ip]);
    } catch (Exception $e) {
        error_log("Error crítico en registrarLog: " . $e->getMessage());
    }
}
?>