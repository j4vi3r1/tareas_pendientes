<?php
// tareas.php
require_once 'auth.php'; // Protege la página
$db = require_once 'db.php'; 
require_once 'logger.php'; // Importamos el archivo de logs

// Capturamos la acción enviada desde el menú (si no hay, por defecto es 'consultar')
$accion_actual = isset($_GET['accion']) ? $_GET['accion'] : 'consultar';

// Registramos el evento de "consultar registro" (Punto 7.3 de la rúbrica)
registrarLog($db, "consultar registro", "El usuario visualizó la interfaz en modo: " . $accion_actual);
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

    <?php if ($accion_actual === 'crear'): ?>
    <div id="formulario-crear" class="card p-4 mb-4 shadow-sm border-primary">
        <h4 class="mb-3 text-primary">Crear Nueva Tarea</h4>
        <form action="process.php" method="POST" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="nombre" class="form-control" placeholder="Escribe aquí tu tarea..." required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="agregar" class="btn btn-primary w-100">Crear</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div id="tabla-consultar" class="d-flex align-items-center justify-content-between my-4">
        <h2 class="m-0">
            <?php 
                if ($accion_actual === 'modificar') echo "Modificar Tareas";
                elseif ($accion_actual === 'eliminar') echo "Eliminar Tareas";
                elseif ($accion_actual === 'crear') echo "Tareas Registradas";
                else echo "Listado de Tareas (Consultar)";
            ?>
        </h2>
        <span class="badge bg-primary p-2">Vista: <?php echo ucfirst($accion_actual); ?></span>
    </div>

    <table class="table table-hover shadow-sm align-middle bg-white rounded">
        <thead class="table-light">
            <tr>
                <th>Tarea</th>
                <th>Estado</th>
                <?php if ($accion_actual === 'modificar' || $accion_actual === 'eliminar'): ?>
                    <th class="text-center" style="width: 250px;">Acción Requerida</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $db->prepare("SELECT * FROM tareas WHERE user_id = ? ORDER BY id DESC");
            $stmt->execute([$_SESSION['user_id']]);
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estado = $row['estado'];
                
                echo "<tr>
                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                    <td><span class='badge " . ($estado == 'completada' ? 'bg-success' : 'bg-secondary') . "'>" . ucfirst($estado) . "</span></td>";
                
                // CONTROL EXCLUSIVO DE BOTONES SEGÚN LA OPERACIÓN DEL CRUD
                if ($accion_actual === 'modificar' || $accion_actual === 'eliminar') {
                    echo "<td class='text-center'>";
                    
                    // Si se presionó "Modificar", aparece el botón de cambiar Estado Y el de Editar Nombre
                    if ($accion_actual === 'modificar') {
                        $btn_txt = ($estado == 'completada') ? 'Desmarcar' : 'Completar';
                        $color_btn = ($estado == 'completada') ? 'btn-success' : 'btn-warning';
                        
                        // Botón de Estado alternable
                        echo "<a href='process.php?cambiar_estado={$row['id']}&estado={$estado}' class='btn btn-sm $color_btn me-2'>$btn_txt</a>";
                        // Botón de Editar Nombre
                        echo "<a href='editar.php?id={$row['id']}' class='btn btn-sm btn-info text-white'>Editar</a>";
                    }
                    
                    // Si se presionó "Eliminar", SÓLO aparece el botón rojo de Eliminar
                    if ($accion_actual === 'eliminar') {
                        echo "<a href='process.php?eliminar={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Seguro que deseas eliminar esta tarea?\")'>Eliminar</a>";
                    }
                    
                    echo "</td>";
                }
                
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>