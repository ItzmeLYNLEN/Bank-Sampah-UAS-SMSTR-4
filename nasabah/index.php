<?php
session_start();
include '../koneksi.php';

if($_SESSION['status_nasabah'] != "login"){ 
    header("location:../index.php?pesan=belum_login"); 
    exit(); 
}

$id = $_SESSION['id_nasabah'];
$q = mysqli_query($conn, "SELECT saldo FROM nasabah WHERE id_nasabah='$id'");
$r = mysqli_fetch_assoc($q);

include 'header.php';
?>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Beranda</h3>
        <p class="text-muted">Halo, <?php echo $_SESSION['nama_nasabah']; ?>! Selamat datang kembali.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card balance-card p-4 h-100 d-flex flex-column justify-content-center">
                <p class="mb-1 opacity-75 fw-medium small text-uppercase">Total Saldo Tabungan Anda</p>
                <h1 class="display-5 fw-bold mb-0">Rp <?php echo number_format($r['saldo'],0,',','.'); ?></h1>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 h-100 border-start border-success border-4 shadow-sm">
                <h5 class="fw-bold mb-2 text-success"><i class="fa-solid fa-circle-info"></i> Informasi Tabungan</h5>
                <p class="text-muted small mb-0">
                    Saldo Anda akan otomatis bertambah setiap kali Anda menyetorkan sampah di posko Bank Sampah. 
                    Anda bisa menarik saldo Anda secara tunai melalui Admin di kantor pusat. 
                    Pastikan Anda mengecek katalog harga terbaru setiap minggu.
                </p>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-3 bg-white shadow-sm border-0">
                <p class="mb-0 text-muted small">
                    <i class="fa-solid fa-leaf text-success me-2"></i> 
                    Mari terus memilah sampah dari rumah untuk lingkungan yang lebih bersih!
                </p>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>