<?php
// login.php
session_start();
$db = require_once 'db.php';

$error = '';
if (isset($_POST['ingresar'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Consultamos al usuario
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificamos contraseña con password_verify
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
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
                    <label class="form-label">Nombre de Usuario</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="ingresar" class="btn btn-success w-100">Entrar</button>
            </form>
            
            <hr class="my-4">
            <p class="text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>