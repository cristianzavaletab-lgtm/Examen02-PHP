<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Hotel - Sistema de Reservas</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0f172a;
            --accent-color: #3b82f6;
            --text-dark: #1e293b;
            --bg-color: #f8fafc;
        }
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--bg-color);
            color: var(--text-dark);
        }
        .navbar { 
            background: rgba(15, 23, 42, 0.95); 
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: #fff !important;
        }
        .navbar-brand i { color: var(--accent-color); }
        .nav-link { 
            color: #cbd5e1 !important; 
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem !important;
        }
        .nav-link:hover { 
            color: #fff !important;
            background: rgba(255,255,255,0.1);
        }
        .nav-link.active {
            color: #fff !important;
            background: var(--accent-color);
        }
        /* Card Styles */
        .card { 
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            background: #fff;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .img-preview { 
            height: 250px; 
            object-fit: cover; 
            transition: transform 0.5s ease;
        }
        .card:hover .img-preview {
            transform: scale(1.05);
        }
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        /* Table Styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .badge {
            padding: 0.5em 1em;
            border-radius: 2rem;
            font-weight: 500;
        }
        .badge-Simple { background-color: #94a3b8; }
        .badge-Doble { background-color: #3b82f6; }
        .badge-Matrimonial { background-color: #ec4899; }
        .badge-Suite { background-color: #eab308; color: #000; }
        
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fa-solid fa-hotel me-2"></i>Grand Hotel</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">
                            <i class="fa-solid fa-bed me-1"></i> Habitaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'reservas.php' ? 'active' : '' ?>" href="reservas.php">
                            <i class="fa-solid fa-calendar-check me-1"></i> Reservas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
