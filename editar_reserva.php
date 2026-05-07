<?php
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: reservas.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM reservas WHERE id = ?");
$stmt->execute([$id]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    header("Location: reservas.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];

    // Validación básica: la fecha de salida debe ser mayor a la de entrada
    if (strtotime($fecha_salida) <= strtotime($fecha_entrada)) {
        $error = "La fecha de salida debe ser posterior a la fecha de entrada.";
    } else {
        $stmt = $pdo->prepare("UPDATE reservas SET habitacion_id = ?, fecha_entrada = ?, fecha_salida = ? WHERE id = ?");
        $stmt->execute([$habitacion_id, $fecha_entrada, $fecha_salida, $id]);
        header("Location: reservas.php");
        exit();
    }
}

// Obtener habitaciones para el select
$stmt = $pdo->query("SELECT id, numero, tipo FROM habitaciones");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<div class="card max-w-md mx-auto">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="fa-solid fa-pen-to-square me-2"></i>Editar Reserva</h4>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="editar_reserva.php?id=<?= $id ?>" method="POST">
            <div class="mb-3">
                <label for="habitacion_id" class="form-label">Cambiar Habitación</label>
                <select class="form-select" id="habitacion_id" name="habitacion_id" required>
                    <?php foreach ($habitaciones as $hab): ?>
                        <option value="<?= $hab['id'] ?>" <?= $hab['id'] == $reserva['habitacion_id'] ? 'selected' : '' ?>>
                            Habitación N° <?= htmlspecialchars($hab['numero']) ?> - <?= htmlspecialchars($hab['tipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" value="<?= $reserva['fecha_entrada'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?= $reserva['fecha_salida'] ?>" required>
            </div>
            <button type="submit" class="btn btn-warning"><i class="fa-solid fa-save me-1"></i>Actualizar Reserva</button>
            <a href="reservas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
