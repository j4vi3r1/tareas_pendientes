<?php
// auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario no está logueado, lo mandamos al login
if (!isset($_SESSION['user_id'])) {
    // Validamos si la página que lo llama NO es la de logs para evitar bloqueos extraños en Codespaces
    if (basename($_SERVER['PHP_SELF']) !== 'logs_view.php') {
        header("Location: login.php");
        exit();
    }
}
?>