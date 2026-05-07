<?php
require 'config.php';
require 'header.php';

$stmt = $pdo->query("SELECT * FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h2 class="mb-0">Gestión de Habitaciones</h2>
    <a href="crear_habitacion.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Nueva Habitación</a>
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
                    <a href="editar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-outline-warning w-45"><i class="fa-solid fa-pen me-1"></i> Editar</a>
                    <a href="eliminar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-outline-danger w-45" onclick="return confirm('¿Seguro que deseas eliminar esta habitación?')"><i class="fa-solid fa-trash me-1"></i> Eliminar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if(empty($habitaciones)): ?>
        <div class="col-12">
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-bed fa-4x mb-3 opacity-25"></i>
                <h5>No hay habitaciones registradas.</h5>
                <p>Haz clic en "Nueva Habitación" para empezar.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
