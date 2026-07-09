<?php
// registro.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';
require_once 'logger.php';

$mensaje = '';

if (isset($_POST['registrar'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $error_detectado = false;

    // Validación simplificada en el Backend
    if (strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "<div class='alert alert-danger shadow-sm fw-semibold'>⚠️ Por favor, verifica que el usuario tenga 3 caracteres y el correo sea válido.</div>";
        $error_detectado = true;
    } 
    // Valida el largo, mayúscula, número y símbolo en un único paso con expresiones regulares
    elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        $mensaje = "<div class='alert alert-danger shadow-sm'>🔒 <strong>Contraseña insegura:</strong> Debe incluir al menos 8 caracteres, una mayúscula, un número y un símbolo.</div>";
        $error_detectado = true;
    }

    // Si no se gatilló ninguna alerta de error, guardamos limpiamente
    if (!$error_detectado) {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO usuarios (username, email, password, verificado) VALUES (?, ?, ?, 1)");
            $stmt->execute([$username, $email, $hash]);

            registrarLog($db, "crear usuario", "Usuario registrado y verificado automáticamente: " . $username);
            $mensaje = "<div class='alert alert-success shadow-sm fw-bold'>🎉 ¡Registro exitoso! Tu cuenta ya está activa. Redirigiendo...</div>";
            
            header("refresh:2;url=login.php");

        } catch (PDOException $e) {
            $mensaje = "<div class='alert alert-danger shadow-sm fw-bold'>❌ El nombre de usuario o el correo electrónico ya se encuentran registrados.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .password-toggle:hover { color: #495057; }
        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 38px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 440px;">
        <div class="card shadow-sm p-4 border-0">
            <h3 class="text-center mb-4 fw-bold text-primary">Crear Cuenta</h3>
            
            <?php if (!empty($mensaje)): ?>
                <?php echo $mensaje; ?>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre de Usuario</label>
                    <input type="text" name="username" class="form-control" minlength="3" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" placeholder="Mínimo 3 caracteres" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="ejemplo@correo.com" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-control" 
                               pattern="(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}"
                               placeholder="Mayúscula, número y símbolo" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                    <div class="form-text mt-1" style="font-size: 0.8rem; color: #6c757d;">
                        Debe incluir mínimo 8 caracteres, una mayúscula, un número y un símbolo.
                    </div>
                </div>
                
                <button type="submit" name="registrar" class="btn btn-primary w-100 mb-3 fw-bold">Registrarse</button>
                <div class="text-center">
                    <a href="login.php" class="btn btn-outline-secondary btn-sm w-100">¿Ya tienes cuenta? Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>