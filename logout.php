<?php
// logout.php
session_start();
$db = require_once 'db.php';
require_once 'logger.php'; // Importamos la función para registrar el evento

// Registramos el evento de cierre de sesión (Tipo 3)
registrarLog($db, "cierre de sesion", "El usuario cerró su sesión actual.");

// Destruimos la sesión y redirigimos
session_destroy();
header("Location: login.php");
exit();
?>