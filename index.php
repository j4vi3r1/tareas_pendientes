<?php 
// index.php
// Importamos la conexión a la base de datos
$db = require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto CRUD - Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="text-primary text-center">Mi Gestor de Tareas</h1>

    <form action="process.php" method="POST" class="row g-3 mt-4 justify-content-center">
        <div class="col-auto w-75">
            <input type="text" name="nombre" class="form-control" placeholder="Ej: Comprar pan para la once..." required>
        </div>
        <div class="col-auto">
            <button type="submit" name="agregar" class="btn btn-primary">Añadir Tarea</button>
        </div>
    </form>

    <h2 class="mt-5">Tus Pendientes</h2>
    <table class="table table-hover mt-3">
        <tbody>
            <?php
            // Consultamos las tareas ordenadas por ID de forma descendente
            $stmt = $db->query("SELECT * FROM tareas ORDER BY id DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estado = $row['estado']; // 'pendiente' o 'completada'
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

    <hr class="mt-5">
    <section>
        <h2>Integrantes:</h2>
        <ul>
            <li>Ricardo González</li>
            <li>Monserrat Palma</li>
            <li>Javier Quezada</li>
        </ul>
    </section>

</body>
</html>