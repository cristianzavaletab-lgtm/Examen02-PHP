<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $imagen = null;

    // Subida de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imagenName = time() . '_' . basename($_FILES['imagen']['name']);
        $uploadFile = $uploadDir . $imagenName;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
            $imagen = $imagenName;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO habitaciones (numero, tipo, imagen) VALUES (?, ?, ?)");
    $stmt->execute([$numero, $tipo, $imagen]);

    header("Location: index.php");
    exit();
}

require 'header.php';
?>

<div class="card max-w-md mx-auto">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Crear Nueva Habitación</h4>
    </div>
    <div class="card-body">
        <form action="crear_habitacion.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="numero" class="form-label">Número de Habitación</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Habitación</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="Simple">Simple</option>
                    <option value="Doble">Doble</option>
                    <option value="Matrimonial">Matrimonial</option>
                    <option value="Suite">Suite</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen de la Habitación</label>
                <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Guardar Habitación</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
