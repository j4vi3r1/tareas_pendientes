<?php
// logs_view.php
require_once 'auth.php'; // Protege la página, solo usuarios logueados pueden ver los logs
$db = require_once 'db.php';

// Consulta para obtener los logs unidos con los nombres de usuario
$query = "SELECT l.*, u.username 
          FROM logs l 
          LEFT JOIN usuarios u ON l.usuario_id = u.id 
          ORDER BY l.fecha_hora DESC";
$stmt = $db->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Auditoría de Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-4">
        <h2>Registro de Auditoría (Logs)</h2>
        <p class="text-muted">Historial de eventos del sistema en orden cronológico.</p>
        
        <a href="index.php" class="btn btn-secondary mb-3">Volver al Inicio</a>
        
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Usuario</th>
                            <th>Evento</th>
                            <th>Detalle</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['fecha_hora']; ?></td>
                            <td><?php echo $row['username'] ?? 'Sistema'; ?></td>
                            <td><span class="badge bg-info"><?php echo $row['evento']; ?></span></td>
                            <td><?php echo htmlspecialchars($row['detalle']); ?></td>
                            <td><?php echo $row['ip_host_client']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>