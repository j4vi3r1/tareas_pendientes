<?php
// logger.php
function registrarLog($db, $evento, $detalle = "") {
    $user_id = $_SESSION['user_id'] ?? null;
    
    // Intentamos obtener la IP real si viene a través de un proxy
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // La cabecera X-Forwarded-For puede traer varias IPs (separadas por coma),
        // la primera es la IP real del cliente.
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    $stmt = $db->prepare("INSERT INTO logs (usuario_id, evento, detalle, ip_host_client) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $evento, $detalle, $ip]);
}
?>