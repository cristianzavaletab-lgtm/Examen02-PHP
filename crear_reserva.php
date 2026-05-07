<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];

    $stmt = $pdo->prepare("INSERT INTO reservas (habitacion_id, fecha_entrada, fecha_salida) VALUES (?, ?, ?)");
    $stmt->execute([$habitacion_id, $fecha_entrada, $fecha_salida]);

    header("Location: reservas.php");
    exit();
}

// Obtener habitaciones para el select (Relación de tablas)
$stmt = $pdo->query("SELECT id, numero, tipo FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<div class="card max-w-md mx-auto">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Crear Nueva Reserva</h4>
    </div>
    <div class="card-body">
        <form action="crear_reserva.php" method="POST">
            <div class="mb-3">
                <label for="habitacion_id" class="form-label">Seleccionar Habitación</label>
                <select class="form-select" id="habitacion_id" name="habitacion_id" required>
                    <option value="">Seleccione una habitación...</option>
                    <?php foreach ($habitaciones as $hab): ?>
                        <option value="<?= $hab['id'] ?>">
                            Habitación N° <?= htmlspecialchars($hab['numero']) ?> - <?= htmlspecialchars($hab['tipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if(empty($habitaciones)): ?>
                    <small class="text-danger">Debes crear al menos una habitación primero.</small>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" required>
            </div>
            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
            </div>
            <button type="submit" class="btn btn-success" <?= empty($habitaciones) ? 'disabled' : '' ?>>Guardar Reserva</button>
            <a href="reservas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
