<?php
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM habitaciones WHERE id = ?");
$stmt->execute([$id]);
$habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$habitacion) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $imagen = $habitacion['imagen']; // Mantener imagen actual

    // Subida de nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imagenName = time() . '_' . basename($_FILES['imagen']['name']);
        $uploadFile = $uploadDir . $imagenName;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
            // Eliminar imagen anterior si existe
            if ($imagen && file_exists('uploads/' . $imagen)) {
                unlink('uploads/' . $imagen);
            }
            $imagen = $imagenName;
        }
    }

    $stmt = $pdo->prepare("UPDATE habitaciones SET numero = ?, tipo = ?, imagen = ? WHERE id = ?");
    $stmt->execute([$numero, $tipo, $imagen, $id]);

    header("Location: index.php");
    exit();
}

require 'header.php';
?>

<div class="card max-w-md mx-auto">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Editar Habitación</h4>
    </div>
    <div class="card-body">
        <form action="editar_habitacion.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="numero" class="form-label">Número de Habitación</label>
                <input type="text" class="form-control" id="numero" name="numero" value="<?= htmlspecialchars($habitacion['numero']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Habitación</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="Simple" <?= $habitacion['tipo'] == 'Simple' ? 'selected' : '' ?>>Simple</option>
                    <option value="Doble" <?= $habitacion['tipo'] == 'Doble' ? 'selected' : '' ?>>Doble</option>
                    <option value="Matrimonial" <?= $habitacion['tipo'] == 'Matrimonial' ? 'selected' : '' ?>>Matrimonial</option>
                    <option value="Suite" <?= $habitacion['tipo'] == 'Suite' ? 'selected' : '' ?>>Suite</option>
                </select>
            </div>
            <?php if ($habitacion['imagen']): ?>
                <div class="mb-3">
                    <p>Imagen actual:</p>
                    <img src="uploads/<?= htmlspecialchars($habitacion['imagen']) ?>" alt="Imagen actual" style="max-height: 100px;">
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="imagen" class="form-label">Subir nueva imagen (opcional)</label>
                <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Actualizar Habitación</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
