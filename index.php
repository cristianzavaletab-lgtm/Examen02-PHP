<?php
require 'config.php';
require 'header.php';

// Filtros
$searchNumero = $_GET['search_numero'] ?? '';
$searchTipo = $_GET['search_tipo'] ?? '';

$query = "SELECT * FROM habitaciones WHERE 1=1";
$params = [];

if (!empty($searchNumero)) {
    $query .= " AND numero LIKE ?";
    $params[] = "%$searchNumero%";
}

if (!empty($searchTipo)) {
    $query .= " AND tipo = ?";
    $params[] = $searchTipo;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center page-header mb-4 border-0">
    <div>
        <h2 class="mb-1">Catálogo de Habitaciones</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Explora nuestra selección de espacios exclusivos.</p>
    </div>
    <a href="crear_habitacion.php" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i> Añadir Habitación</a>
</div>

<!-- Filtros Elegant Form -->
<form action="index.php" method="GET" class="mb-5">
    <div class="row g-3 align-items-end p-4" style="background: var(--card-bg); border: 1px solid var(--border-color);">
        <div class="col-md-5">
            <label class="form-label" style="font-size: 0.85rem; letter-spacing: 1px; color: var(--accent-gold); text-transform: uppercase;">N° de Habitación</label>
            <input type="text" name="search_numero" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($searchNumero) ?>">
        </div>
        <div class="col-md-5">
            <label class="form-label" style="font-size: 0.85rem; letter-spacing: 1px; color: var(--accent-gold); text-transform: uppercase;">Categoría</label>
            <select name="search_tipo" class="form-select">
                <option value="">Todas las categorías</option>
                <option value="Simple" <?= $searchTipo == 'Simple' ? 'selected' : '' ?>>Simple</option>
                <option value="Doble" <?= $searchTipo == 'Doble' ? 'selected' : '' ?>>Doble</option>
                <option value="Matrimonial" <?= $searchTipo == 'Matrimonial' ? 'selected' : '' ?>>Matrimonial</option>
                <option value="Suite" <?= $searchTipo == 'Suite' ? 'selected' : '' ?>>Suite</option>
            </select>
        </div>
        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-outline-warning w-100 me-2" title="Filtrar"><i class="fa-solid fa-filter"></i></button>
            <?php if(!empty($searchNumero) || !empty($searchTipo)): ?>
                <a href="index.php" class="btn btn-outline-danger w-100" title="Limpiar"><i class="fa-solid fa-times"></i></a>
            <?php endif; ?>
        </div>
    </div>
</form>

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
