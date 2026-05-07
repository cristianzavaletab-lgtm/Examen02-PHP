<?php
require 'config.php';
require 'header.php';

// Consulta con JOIN para relacionar reservas con habitaciones
$query = "
    SELECT r.id, r.fecha_entrada, r.fecha_salida, h.numero, h.tipo 
    FROM reservas r
    JOIN habitaciones h ON r.habitacion_id = h.id
    ORDER BY r.fecha_entrada DESC
";
$stmt = $pdo->query($query);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Reservas</h2>
    <a href="crear_reserva.php" class="btn btn-primary">➕ Nueva Reserva</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= $reserva['id'] ?></td>
                            <td>N° <?= htmlspecialchars($reserva['numero']) ?></td>
                            <td><?= htmlspecialchars($reserva['tipo']) ?></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_entrada'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></td>
                            <td>
                                <a href="eliminar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas cancelar/eliminar esta reserva?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($reservas)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay reservas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
