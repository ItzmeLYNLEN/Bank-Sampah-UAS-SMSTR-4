<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nasabah - Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa; 
            overflow-x: hidden; 
        }
        .sidebar { 
            min-width: 250px; 
            max-width: 250px; 
            background: #fff; 
            border-right: 1px solid #e9ecef; 
            min-height: 100vh; 
            transition: all 0.3s; 
        }
        .nav-link { 
            color: #6c757d; 
            font-weight: 500; 
            padding: 12px 20px; 
            border-radius: 8px; 
            margin: 4px 15px; 
        }
        .nav-link:hover, .nav-link.active { 
            background-color: #e8f5e9; 
            color: #198754; 
        }
        .nav-link i { 
            width: 25px; 
        }
        .content { 
            width: 100%; 
            padding: 30px; 
            transition: all 0.3s; 
        }
        .balance-card { 
            background: linear-gradient(135deg, #198754 0%, #20c997 100%); 
            color: white; 
            border: none; 
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2);
        }
        @media (max-width: 768px) {
            .sidebar { 
                margin-left: -250px; 
                position: fixed; 
                z-index: 1050; 
            }
            .sidebar.active { 
                margin-left: 0 !important; 
            }
            .content { 
                padding: 20px; 
            }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <nav class="sidebar shadow-sm" id="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold text-success"><i class="fa-solid fa-leaf"></i> Bank Sampah</h4>
            <p class="small text-muted mb-0">Halaman Warga</p>
            <hr>
        </div>
        <div class="nav flex-column">
            <a href="index.php" class="nav-link"><i class="fa-solid fa-house"></i> Beranda</a>
            <a href="riwayat.php" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</a>
            <a href="katalog.php" class="nav-link"><i class="fa-solid fa-tags"></i> Harga Sampah</a>
            <div class="mt-5 p-3">
                <a href="#" onclick="konfirmasiLogout()" class="btn btn-outline-danger w-100 btn-md fw-bold">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <div class="content">
        <nav class="navbar navbar-expand-lg mb-4 rounded shadow-sm d-md-none border bg-white">
            <div class="container-fluid">
                <button class="btn btn-success" id="toggleSidebar">
                    <i class="fa-solid fa-bars"></i> Menu
                </button>
                <span class="fw-bold text-success small">Bank Sampah</span>
            </div>
        </nav>