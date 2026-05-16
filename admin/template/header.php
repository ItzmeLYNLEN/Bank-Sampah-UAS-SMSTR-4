<?php
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$base_admin = ($current_dir == 'admin') ? '' : '../';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-width: 250px; max-width: 250px; background: #fff; border-right: 1px solid #e9ecef; min-height: 100vh; transition: all 0.3s; }
        .nav-link { color: #6c757d; font-weight: 500; padding: 12px 20px; border-radius: 8px; margin: 4px 15px; }
        .nav-link:hover, .nav-link.active { background-color: #e8f5e9; color: #198754; }
        .nav-link i { width: 25px; }
        .content { width: 100%; padding: 30px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        @media (max-width: 768px) { .sidebar { margin-left: -250px; position: fixed; z-index: 1000; } .sidebar.active { margin-left: 0; } }
        @media print { .no-print { display: none !important; } .content { padding: 0; } }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="sidebar shadow-sm no-print" id="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold text-success"><i class="fa-solid fa-leaf"></i> Bank Sampah</h4>
            <hr>
        </div>
        <div class="nav flex-column">
            <a href="<?php echo $base_admin; ?>index.php" class="nav-link"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="<?php echo $base_admin; ?>nasabah/data_nasabah.php" class="nav-link"><i class="fa-solid fa-users"></i> Data Nasabah</a>
            <a href="<?php echo $base_admin; ?>jenis_sampah/katalog_sampah.php" class="nav-link"><i class="fa-solid fa-tags"></i> Master Katalog</a>
            <a href="<?php echo $base_admin; ?>setor/setoran.php" class="nav-link"><i class="fa-solid fa-arrow-down"></i> Setoran</a>
            <a href="<?php echo $base_admin; ?>penarikan/penarikan.php" class="nav-link"><i class="fa-solid fa-arrow-up"></i> Penarikan</a>
            <a href="<?php echo $base_admin; ?>laporan.php" class="nav-link"><i class="fa-solid fa-file-lines"></i> Laporan</a>
            <a href="<?php echo $base_admin; ?>data_admin.php" class="nav-link"><i class="fa-solid fa-user-gear"></i> Kelola Admin</a>
            <div class="mt-5 p-3">
                <a href="#" onclick="konfirmasiLogout('<?php echo $base_admin; ?>logout.php')" class="btn btn-outline-danger w-100 fw-bold">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="content">
        <nav class="navbar navbar-expand-lg mb-4 rounded shadow-sm d-md-none no-print border bg-white">
            <div class="container-fluid">
                <button class="btn btn-success" id="toggleSidebar"><i class="fa-solid fa-bars"></i> Menu</button>
            </div>
        </nav>