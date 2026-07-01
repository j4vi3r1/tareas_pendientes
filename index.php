<?php
// index.php
require_once 'auth.php'; // Protege la página
$db = require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary">Mi Gestor de Tareas</h1>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>

    <form action="process.php" method="POST" class="row g-3 mt-4 justify-content-center">
        <div class="col-auto w-75">
            <input type="text" name="nombre" class="form-control" placeholder="Nueva tarea..." required>
        </div>
        <div class="col-auto">
            <button type="submit" name="agregar" class="btn btn-primary">Añadir</button>
        </div>
    </form>

    <h2 class="mt-5">Tus Pendientes</h2>
    <table class="table table-hover mt-3">
        <tbody>
            <?php
            // Filtramos tareas por el ID del usuario en sesión
            $stmt = $db->prepare("SELECT * FROM tareas WHERE user_id = ? ORDER BY id DESC");
            $stmt->execute([$_SESSION['user_id']]);
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estado = $row['estado'];
                $icono = ($estado == 'completada') ? '✅' : '⏳';
                $btn_txt = ($estado == 'completada') ? 'Desmarcar' : 'Completar';
                $color_boton = ($estado == 'completada') ? 'btn-success' : 'btn-warning';
                
                echo "<tr>
                    <td class='align-middle'>$icono " . htmlspecialchars($row['nombre']) . "</td>
                    <td class='text-end'>
                        <a href='editar.php?id={$row['id']}' class='btn btn-sm btn-outline-primary'>Editar</a>
                        <a href='process.php?cambiar_estado={$row['id']}&estado={$estado}' class='btn btn-sm $color_boton'>$btn_txt</a>
                        <a href='process.php?eliminar={$row['id']}' class='btn btn-sm btn-outline-danger'>Eliminar</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>