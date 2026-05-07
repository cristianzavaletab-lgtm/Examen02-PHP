<?php
require 'config.php';

echo "Limpiando datos antiguos...\n";
$pdo->exec("DELETE FROM reservas");
$pdo->exec("DELETE FROM habitaciones");
$pdo->exec("UPDATE sqlite_sequence SET seq = 0 WHERE name IN ('reservas', 'habitaciones')");

echo "Descargando imágenes de muestra...\n";
$images = [
    'room1.jpg' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=500&q=80',
    'room2.jpg' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=500&q=80',
    'room3.jpg' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=500&q=80',
    'room4.jpg' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=500&q=80',
    'room5.jpg' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=500&q=80',
    'room6.jpg' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=500&q=80',
];

if (!is_dir('uploads')) {
    mkdir('uploads');
}

foreach ($images as $filename => $url) {
    if (!file_exists('uploads/' . $filename)) {
        file_put_contents('uploads/' . $filename, file_get_contents($url));
    }
}

echo "Insertando 6 habitaciones...\n";
$stmt = $pdo->prepare("INSERT INTO habitaciones (numero, tipo, imagen) VALUES (?, ?, ?)");
$stmt->execute(['101', 'Simple', 'room1.jpg']); $hab1 = $pdo->lastInsertId();
$stmt->execute(['102', 'Simple', 'room4.jpg']); $hab2 = $pdo->lastInsertId();
$stmt->execute(['205', 'Doble', 'room2.jpg']); $hab3 = $pdo->lastInsertId();
$stmt->execute(['206', 'Doble', 'room5.jpg']); $hab4 = $pdo->lastInsertId();
$stmt->execute(['301', 'Suite', 'room3.jpg']); $hab5 = $pdo->lastInsertId();
$stmt->execute(['302', 'Matrimonial', 'room6.jpg']); $hab6 = $pdo->lastInsertId();

echo "Insertando reservas...\n";
$stmt = $pdo->prepare("INSERT INTO reservas (habitacion_id, fecha_entrada, fecha_salida) VALUES (?, ?, ?)");
$stmt->execute([$hab1, date('Y-m-d'), date('Y-m-d', strtotime('+3 days'))]);
$stmt->execute([$hab3, date('Y-m-d', strtotime('+1 days')), date('Y-m-d', strtotime('+5 days'))]);
$stmt->execute([$hab5, date('Y-m-d', strtotime('+7 days')), date('Y-m-d', strtotime('+10 days'))]);
$stmt->execute([$hab2, date('Y-m-d', strtotime('+2 days')), date('Y-m-d', strtotime('+4 days'))]);
$stmt->execute([$hab6, date('Y-m-d', strtotime('+14 days')), date('Y-m-d', strtotime('+20 days'))]);

echo "¡Base de datos poblada exitosamente con más datos!\n";
?>
