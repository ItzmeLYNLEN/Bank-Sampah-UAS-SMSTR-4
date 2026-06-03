<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:admin/");
    exit();
} else if(isset($_SESSION['status_nasabah']) && $_SESSION['status_nasabah'] == "login"){
    header("location:nasabah/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); display: flex; width: 900px; max-width: 100%; min-height: 550px; }
        .form-panel { flex: 1; padding: 50px; display: flex; flex-direction: column; justify-content: center; }
        .overlay-panel { flex: 1; background: linear-gradient(135deg, #198754 0%, #20c997 100%); color: white; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; text-align: center; }
        .input-group-text { background-color: transparent; border-left: none; cursor: pointer; }
        .form-control:focus { box-shadow: none; border-color: #198754; }
        .btn-success { padding: 12px; border-radius: 10px; font-weight: 600; background: #198754; border: none; }
        @media (max-width: 768px) { .overlay-panel { display: none; } }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-container shadow">
        <div class="form-panel">
            <h2 class="fw-bold mb-4">Login</h2>
            <form action="login_proses.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-medium">Username / No. HP</label>
                    <input type="text" name="username_hp" class="form-control" placeholder="Masukkan akun Anda" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-medium">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="border-right: none;">
                        <span class="input-group-text" id="togglePassword"><i class="fa-solid fa-eye-slash text-muted"></i></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100 mb-4 shadow-sm">Masuk</button>
            </form>
            <div class="mt-auto text-center small text-muted">
                <p class="mb-0 fw-semibold">Sistem Informasi Bank Sampah</p>
                <p>Bank Sampah Sri Rejeki</p>
            </div>
        </div>
        <div class="overlay-panel text-white">
            <i class="fa-solid fa-leaf fa-4x mb-4"></i>
            <h2 class="fw-bold">Selamat Datang!</h2>
            <p class="opacity-75">Kelola sampah jadi berkah. Pantau saldo tabungan warga dengan mudah dan transparan.</p>
        </div>
    </div>
</div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const icon = togglePassword.querySelector('i');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pesan') === 'gagal') {
        Swal.fire({ icon: 'error', title: 'Login Gagal', text: 'Username atau Password salah!', confirmButtonColor: '#198754' });
    } else if (urlParams.get('pesan') === 'belum_login') {
        Swal.fire({ icon: 'warning', title: 'Akses Ditolak', text: 'Silakan login terlebih dahulu!', confirmButtonColor: '#198754' });
    }
</script>
</body>
</html>