<?php
// setup.php
require 'config.php';

try {
    // Crear tabla habitaciones
    $pdo->exec("CREATE TABLE IF NOT EXISTS habitaciones (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        numero TEXT NOT NULL,
        tipo TEXT NOT NULL,
        imagen TEXT
    )");

    // Crear tabla reservas
    $pdo->exec("CREATE TABLE IF NOT EXISTS reservas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        fecha_entrada DATE NOT NULL,
        fecha_salida DATE NOT NULL,
        habitacion_id INTEGER NOT NULL,
        FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id) ON DELETE CASCADE
    )");

    echo "Base de datos configurada correctamente.";
} catch (PDOException $e) {
    echo "Error al crear tablas: " . $e->getMessage();
}
?>
