<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener información para borrar la imagen si existe
    $stmt = $pdo->prepare("SELECT imagen FROM habitaciones WHERE id = ?");
    $stmt->execute([$id]);
    $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($habitacion) {
        if ($habitacion['imagen'] && file_exists('uploads/' . $habitacion['imagen'])) {
            unlink('uploads/' . $habitacion['imagen']);
        }

        $stmt = $pdo->prepare("DELETE FROM habitaciones WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: index.php");
exit();
?>
