<?php
// activar.php
require_once 'db.php'; // Asegúrate de que este archivo devuelva la variable $db

$mensaje = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // 1. Buscamos al usuario que tenga ese token
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // 2. Si existe, lo marcamos como verificado y eliminamos el token para que no se pueda reutilizar
            $update = $db->prepare("UPDATE usuarios SET verificado = 1, token = NULL WHERE token = ?");
            $update->execute([$token]);
            
            $mensaje = "<div class='alert alert-success'>¡Cuenta activada con éxito! Ya puedes iniciar sesión.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>El enlace no es válido o la cuenta ya fue activada.</div>";
        }
    } catch (PDOException $e) {
        $mensaje = "<div class='alert alert-danger'>Error al conectar con la base de datos.</div>";
    }
} else {
    $mensaje = "<div class='alert alert-warning'>No se proporcionó un token de activación.</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activación de Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm p-4">
            <h3 class="text-center mb-4">Activación de Cuenta</h3>
            <?php echo $mensaje; ?>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary">Ir al inicio de sesión</a>
            </div>
        </div>
    </div>
</body>
</html>