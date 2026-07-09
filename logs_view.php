<?php
// logs_view.php
require_once 'auth.php';   // Protege la página de forma segura con tu archivo original
require_once 'db.php';     // Carga la base de datos de forma global y segura
require_once 'logger.php'; // Importamos el sistema de logs

// Registramos el evento de "consultar registro" (Punto 7.3 de la rúbrica)
registrarLog($db, "consultar registro", "El usuario visualizó el registro de auditoría del sistema.");

// TU CONSULTA ORIGINAL
$query = "SELECT l.*, u.username 
          FROM logs l 
          LEFT JOIN usuarios u ON l.usuario_id = u.id 
          ORDER BY l.id DESC";
$stmt = $db->query($query);

// SOLUCIÓN CLAVE: Extraemos TODOS los registros juntos a un array de memoria de PHP
// Esto evita que SQLite mantenga el puntero abierto y falle al renderizar con Bootstrap
$todos_los_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Auditoría de Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'menu.php'; ?>

    <div class="container mt-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h2>Registro de Auditoría (Logs)</h2>
            <a href="index.php" class="btn btn-secondary btn-sm">Volver al Inicio</a>
        </div>
        <p class="text-muted">Historial completo de eventos del sistema en orden cronológico.</p>
        
        <div class="card shadow-sm border-0 mb-5">
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle mb-0 bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha / Hora</th>
                            <th>Usuario</th>
                            <th>Evento</th>
                            <th>Detalle Técnico (Tabla / ID)</th>
                            <th>IP Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($todos_los_logs)): ?>
                            <?php foreach ($todos_los_logs as $row): 
                                // Punto 7.1: Convertimos la fecha de la BD al formato estricto (DD/MM/YYYY, HH:MM:SS)
                                $fecha_original = $row['fecha_hora'];
                                $timestamp = strtotime($fecha_original);
                                $fecha_formateada = ($timestamp !== false) ? date('d/m/Y, H:i:s', $timestamp) : date('d/m/Y, H:i:s');
                            ?>
                            <tr>
                                <td class="fw-semibold">
                                    <?php echo $fecha_formateada; ?>
                                </td>
                                
                                <td>
                                    <span class="badge <?php echo !empty($row['username']) ? 'bg-secondary' : 'bg-dark'; ?>">
                                        <?php echo !empty($row['username']) ? htmlspecialchars($row['username']) : 'Sistema'; ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="badge bg-info text-dark fw-bold">
                                        <?php echo htmlspecialchars($row['evento']); ?>
                                    </span>
                                </td>
                                
                                <td class="text-muted" style="font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($row['detalle']); ?>
                                </td>
                                
                                <td class="text-monospace"><?php echo htmlspecialchars($row['ip_host_client']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center p-4 text-muted">
                                No se encontraron registros en la bitácora todavía.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>