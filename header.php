<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Hotel - Sistema de Reservas</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0b1121;
            --card-bg: #151e32;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-gold: #d4af37;
            --accent-hover: #b5952f;
            --border-color: rgba(255, 255, 255, 0.05);
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar { 
            background: rgba(11, 17, 33, 0.95); 
            backdrop-filter: blur(10px);
            padding: 1.2rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--accent-gold) !important;
            letter-spacing: 1px;
        }

        .nav-link { 
            color: var(--text-muted) !important; 
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            margin: 0 1rem;
        }

        .nav-link:hover, .nav-link.active { 
            color: var(--accent-gold) !important;
        }

        /* Premium Cards */
        .card { 
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .img-preview { 
            height: 300px; 
            object-fit: cover; 
            filter: brightness(0.85);
            transition: filter 0.5s ease, transform 0.5s ease;
        }

        .card:hover .img-preview {
            filter: brightness(1);
            transform: scale(1.03);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            color: var(--accent-gold);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .card-footer {
            background-color: transparent;
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
        }

        /* Buttons */
        .btn {
            border-radius: 0;
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.8rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--accent-gold);
            border-color: var(--accent-gold);
            color: #000;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            color: #000;
        }

        .btn-outline-warning {
            color: var(--accent-gold);
            border-color: var(--accent-gold);
        }
        .btn-outline-warning:hover {
            background-color: var(--accent-gold);
            color: #000;
        }

        .btn-outline-danger {
            color: #ef4444;
            border-color: #ef4444;
        }
        .btn-outline-danger:hover {
            background-color: #ef4444;
            color: #fff;
        }

        /* Table Premium */
        .table {
            color: var(--text-main);
            border-color: var(--border-color);
            margin-bottom: 0;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(255,255,255,0.02);
            color: var(--accent-gold);
        }

        .table thead th {
            background-color: transparent;
            color: var(--accent-gold);
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            font-family: 'Inter', sans-serif;
            padding: 1.5rem 1rem;
        }

        .table tbody td {
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        /* Badges */
        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 0;
            font-family: 'Inter', sans-serif;
        }
        
        .badge-Simple { background-color: rgba(255,255,255,0.1); color: var(--text-main); }
        .badge-Doble { background-color: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .badge-Matrimonial { background-color: rgba(236, 72, 153, 0.2); color: #f472b6; }
        .badge-Suite { background-color: rgba(212, 175, 55, 0.2); color: var(--accent-gold); }

        .page-header {
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        /* Form Controls */
        .form-control, .form-select {
            background-color: rgba(0,0,0,0.2);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 0;
            padding: 0.8rem;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(0,0,0,0.4);
            border-color: var(--accent-gold);
            color: var(--text-main);
            box-shadow: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php">GRAND HOTEL</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">
                            Habitaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'reservas.php' ? 'active' : '' ?>" href="reservas.php">
                            Reservas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
