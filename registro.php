<?php
// registro.php
$db = require_once 'db.php';

$mensaje = '';
if (isset($_POST['registrar'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='alert alert-danger'>El formato del correo no es válido.</div>";
    } elseif (!empty($username) && !empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $db->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            header("Location: login.php?msg=exito");
            exit();
        } catch (PDOException $e) {
            $mensaje = "<div class='alert alert-danger'>El usuario o correo ya existen.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm p-4">
            <h3 class="text-center mb-4">Crear Cuenta</h3>
            <?php echo $mensaje; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre de Usuario</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" id="passRegistro" class="form-control" required>
                </div>
                
                <button type="submit" name="registrar" class="btn btn-primary w-100">Registrarse</button>
            </form>
            <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
    <script>
        function togglePass(id) {
            var x = document.getElementById(id);
            x.type = (x.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>