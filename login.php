<?php
// login.php
session_start();
$db = require_once 'db.php';
require_once 'logger.php'; // Incluimos el sistema de logs

// Si el usuario ya inició sesión, redirigir al index directamente
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if (isset($_POST['ingresar'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Consultamos al usuario por email
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificamos contraseña
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        
        // Registrar evento: Inicio de sesión
        registrarLog($db, "iniciar sesion", "El usuario con email " . $email . " ha iniciado sesión.");
        
        header("Location: index.php"); 
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm p-4">
            <h3 class="text-center mb-4">Iniciar Sesión</h3>
            
            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'exito'): ?>
                <div class='alert alert-success text-center'>¡Cuenta creada! Ya puedes iniciar sesión.</div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class='alert alert-danger'><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" id="passLogin" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="checkLogin" onclick="togglePass('passLogin')">
                    <label class="form-check-label" for="checkLogin">Mostrar contraseña</label>
                </div>
                
                <button type="submit" name="ingresar" class="btn btn-success w-100">Entrar</button>
            </form>
            
            <hr class="my-4">
            <p class="text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
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