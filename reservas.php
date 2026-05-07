<?php
require 'config.php';
require 'header.php';

// Obtener estadísticas
$stmtStats = $pdo->query("SELECT COUNT(*) as total_reservas FROM reservas");
$totalReservas = $stmtStats->fetchColumn();

$stmtHabStats = $pdo->query("SELECT COUNT(*) as total_habitaciones FROM habitaciones");
$totalHabitaciones = $stmtHabStats->fetchColumn();

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

<!-- Sección de Estadísticas -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Total Habitaciones</h5>
                    <h2 class="display-4 fw-bold mb-0"><?= $totalHabitaciones ?></h2>
                </div>
                <i class="fa-solid fa-bed fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Reservas Registradas</h5>
                    <h2 class="display-4 fw-bold mb-0"><?= $totalReservas ?></h2>
                </div>
                <i class="fa-solid fa-calendar-check fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h2 class="mb-0">Gestión de Reservas</h2>
    <a href="crear_reserva.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Nueva Reserva</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Días</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): 
                        // Calcular número de días
                        $datetime1 = new DateTime($reserva['fecha_entrada']);
                        $datetime2 = new DateTime($reserva['fecha_salida']);
                        $interval = $datetime1->diff($datetime2);
                        $dias = $interval->days;
                    ?>
                        <tr>
                            <td>#<?= $reserva['id'] ?></td>
                            <td class="fw-bold">N° <?= htmlspecialchars($reserva['numero']) ?></td>
                            <td><span class="badge badge-<?= htmlspecialchars($reserva['tipo']) ?>"><?= htmlspecialchars($reserva['tipo']) ?></span></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_entrada'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></td>
                            <td><?= $dias ?> días</td>
                            <td class="text-center">
                                <a href="editar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-sm btn-outline-warning mx-1" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="eliminar_reserva.php?id=<?= $reserva['id'] ?>" class="btn btn-sm btn-outline-danger mx-1 delete-btn" title="Eliminar"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
