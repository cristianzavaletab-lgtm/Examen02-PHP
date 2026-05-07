<?php
require 'config.php';
require 'header.php';

$stmt = $pdo->query("SELECT * FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Habitaciones</h2>
    <a href="crear_habitacion.php" class="btn btn-primary">➕ Nueva Habitación</a>
</div>

<div class="row">
    <?php foreach ($habitaciones as $hab): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($hab['imagen']): ?>
                    <img src="uploads/<?= htmlspecialchars($hab['imagen']) ?>" class="card-img-top img-preview" alt="Habitación">
                <?php else: ?>
                    <div class="bg-secondary text-white text-center py-5">Sin Imagen</div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title">Habitación N° <?= htmlspecialchars($hab['numero']) ?></h5>
                    <p class="card-text"><strong>Tipo:</strong> <?= htmlspecialchars($hab['tipo']) ?></p>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                    <a href="editar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar_habitacion.php?id=<?= $hab['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta habitación?')">Eliminar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if(empty($habitaciones)): ?>
        <div class="col-12"><div class="alert alert-info">No hay habitaciones registradas.</div></div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
