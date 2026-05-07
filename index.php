<?php
require 'config.php';
require 'header.php';

$stmt = $pdo->query("SELECT * FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1">Catálogo de Habitaciones</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Explora nuestra selección de espacios exclusivos.</p>
    </div>
    <a href="crear_habitacion.php" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i> Añadir Habitación</a>
</div>

<div class="row mt-4">
    <?php foreach ($habitaciones as $hab): ?>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <?php if ($hab['imagen']): ?>
                    <div style="overflow: hidden;">
                        <img src="uploads/<?= htmlspecialchars($hab['imagen']) ?>" class="card-img-top img-preview" alt="Habitación">
                    </div>
                <?php else: ?>
                    <div class="text-white text-center py-5 d-flex align-items-center justify-content-center" style="height: 300px; background-color: rgba(255,255,255,0.02);">
                        <i class="fa-solid fa-image fa-3x" style="opacity: 0.1"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge badge-<?= htmlspecialchars($hab['tipo']) ?>"><?= htmlspecialchars($hab['tipo']) ?></span>
                    </div>
                    <h3 class="card-title mt-3 mb-0">N° <?= htmlspecialchars($hab['numero']) ?></h3>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="editar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-outline-warning w-100 me-2"><i class="fa-solid fa-pen me-2"></i> Editar</a>
                    <a href="eliminar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-outline-danger w-100 delete-btn"><i class="fa-solid fa-trash me-2"></i> Eliminar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if(empty($habitaciones)): ?>
        <div class="col-12">
            <div class="text-center py-5" style="border: 1px dashed var(--border-color); margin-top: 2rem;">
                <i class="fa-solid fa-bed fa-3x mb-3" style="color: var(--border-color);"></i>
                <h4 style="color: var(--text-muted)">No hay habitaciones registradas.</h4>
                <p style="color: var(--text-muted); font-size: 0.9rem;">El catálogo está vacío.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
