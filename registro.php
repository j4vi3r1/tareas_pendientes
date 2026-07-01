<?php
// registro.php
$db = require_once 'db.php';

if (isset($_POST['registrar'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        header("Location: login.php?msg=registrado");
    } catch (PDOException $e) {
        $error = "El usuario ya existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5">
    <h2>Registro</h2>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-2" placeholder="Usuario" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>
        <button type="submit" name="registrar" class="btn btn-primary">Registrarse</button>
    </form>
</body>
</html>