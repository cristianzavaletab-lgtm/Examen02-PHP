<?php
require 'config.php';
require 'header.php';

$stmt = $pdo->query("SELECT * FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Datos para el gráfico
$stmtTipos = $pdo->query("SELECT tipo, COUNT(*) as cantidad FROM habitaciones GROUP BY tipo");
$tiposData = $stmtTipos->fetchAll(PDO::FETCH_ASSOC);
$labels = [];
$data = [];
foreach($tiposData as $row) {
    $labels[] = $row['tipo'];
    $data[] = $row['cantidad'];
}
?>

<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-2 page-header border-0">
            <div>
                <h2 class="mb-1 fw-bold">Inventario de Habitaciones</h2>
                <p class="text-muted">Administra el catálogo de habitaciones disponibles en el hotel.</p>
            </div>
            <a href="crear_habitacion.php" class="btn btn-primary shadow"><i class="fa-solid fa-plus me-1"></i> Nueva Habitación</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-2" style="height: 150px; display: flex; justify-content: center;">
                <canvas id="tiposChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($habitaciones as $hab): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($hab['imagen']): ?>
                    <div style="overflow: hidden;">
                        <img src="uploads/<?= htmlspecialchars($hab['imagen']) ?>" class="card-img-top img-preview" alt="Habitación">
                    </div>
                <?php else: ?>
                    <div class="bg-secondary text-white text-center py-5 d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fa-solid fa-image fa-3x opacity-50"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 fw-bold">Habitación N° <?= htmlspecialchars($hab['numero']) ?></h5>
                        <span class="badge badge-<?= htmlspecialchars($hab['tipo']) ?>"><?= htmlspecialchars($hab['tipo']) ?></span>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between pb-3">
                    <a href="editar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-outline-warning w-45 fw-bold"><i class="fa-solid fa-pen me-1"></i> Editar</a>
                    <a href="eliminar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-outline-danger w-45 fw-bold delete-btn"><i class="fa-solid fa-trash me-1"></i> Eliminar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if(empty($habitaciones)): ?>
        <div class="col-12">
            <div class="text-center py-5 text-muted bg-white rounded shadow-sm">
                <i class="fa-solid fa-bed fa-4x mb-3 opacity-25"></i>
                <h5>No hay habitaciones registradas.</h5>
                <p>Haz clic en "Nueva Habitación" para empezar.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('tiposChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        data: <?= json_encode($data) ?>,
                        backgroundColor: ['#94a3b8', '#3b82f6', '#ec4899', '#eab308'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12, font: { size: 10 } } },
                        title: { display: true, text: 'Distribución', font: { size: 12 } }
                    }
                }
            });
        }
    });
</script>

<?php require 'footer.php'; ?>
