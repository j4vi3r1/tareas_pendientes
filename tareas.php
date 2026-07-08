<?php
// tareas.php
require_once 'auth.php'; // Protege la página
$db = require_once 'db.php'; 
require_once 'logger.php'; // 1. Importamos el archivo de logs

// 2. Registramos el evento de "consultar registro"
// Se ejecuta cada vez que el usuario entra a ver su lista de tareas
registrarLog($db, "consultar registro", "El usuario visualizó su lista de tareas");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <?php include 'menu.php'; ?>

    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-3">Crear Nueva Tarea</h4>
        <form action="process.php" method="POST" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="nombre" class="form-control" placeholder="Escribe aquí tu tarea..." required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="agregar" class="btn btn-primary w-100">Crear</button>
            </div>
        </form>
    </div>

    <h2>Tus Tareas</h2>
    <table class="table table-hover mt-3 shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Tarea</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $db->prepare("SELECT * FROM tareas WHERE user_id = ? ORDER BY id DESC");
            $stmt->execute([$_SESSION['user_id']]);
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estado = $row['estado'];
                $btn_txt = ($estado == 'completada') ? 'Desmarcar' : 'Completar';
                $color_btn = ($estado == 'completada') ? 'btn-success' : 'btn-warning';
                
                echo "<tr>
                    <td class='align-middle'>" . htmlspecialchars($row['nombre']) . "</td>
                    <td class='align-middle'>" . ucfirst($estado) . "</td>
                    <td class='text-center'>
                        <a href='process.php?cambiar_estado={$row['id']}&estado={$estado}' class='btn btn-sm $color_btn'>$btn_txt</a>
                        <a href='editar.php?id={$row['id']}' class='btn btn-sm btn-info text-white'>Editar</a>
                        <a href='process.php?eliminar={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Seguro?\")'>Eliminar</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>