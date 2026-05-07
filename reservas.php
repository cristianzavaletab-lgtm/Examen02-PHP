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

<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1">Reservas Activas</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Listado general de reservaciones en el hotel.</p>
    </div>
    <a href="crear_reserva.php" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i> Crear Reserva</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="padding-left: 2rem;">ID</th>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Días</th>
                        <th class="text-end" style="padding-right: 2rem;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): 
                        $datetime1 = new DateTime($reserva['fecha_entrada']);
                        $datetime2 = new DateTime($reserva['fecha_salida']);
                        $interval = $datetime1->diff($datetime2);
                        $dias = $interval->days;
                    ?>
                        <tr>
                            <td style="padding-left: 2rem; color: var(--text-muted);">#<?= str_pad($reserva['id'], 4, '0', STR_PAD_LEFT) ?></td>
                            <td style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--accent-gold);">N° <?= htmlspecialchars($reserva['numero']) ?></td>
                            <td><span class="badge badge-<?= htmlspecialchars($reserva['tipo']) ?>"><?= htmlspecialchars($reserva['tipo']) ?></span></td>
                            <td style="font-weight: 300;"><?= date('d/m/Y', strtotime($reserva['fecha_entrada'])) ?></td>
                            <td style="font-weight: 300;"><?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></td>
                            <td style="font-weight: 300;"><?= $dias ?></td>
                            <td class="text-end" style="padding-right: 2rem;">
                                <a href="editar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-sm btn-outline-warning" style="padding: 0.4rem 0.8rem; font-size: 0.7rem;"><i class="fa-solid fa-pen"></i></a>
                                <a href="eliminar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-sm btn-outline-danger delete-btn ms-2" style="padding: 0.4rem 0.8rem; font-size: 0.7rem;"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($reservas)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fa-solid fa-calendar-xmark fa-2x mb-2" style="color: var(--border-color);"></i>
                                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">No hay reservaciones activas.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
