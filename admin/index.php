<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }
$nasabah = mysqli_query($conn, "SELECT COUNT(*) as total FROM nasabah");
$t_nasabah = mysqli_fetch_assoc($nasabah);
$saldo = mysqli_query($conn, "SELECT SUM(saldo) as total FROM nasabah");
$t_saldo = mysqli_fetch_assoc($saldo);
include 'template/header.php';
?>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard</h3>
        <p class="text-muted small">Ringkasan aktivitas sistem hari ini.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 border-start border-success border-5 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success"><i class="fa-solid fa-users fa-2x"></i></div>
                    <div><p class="text-muted mb-1 small fw-bold">TOTAL NASABAH</p><h3 class="fw-bold mb-0"><?php echo $t_nasabah['total']; ?></h3></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-4 border-start border-primary border-5 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary"><i class="fa-solid fa-wallet fa-2x"></i></div>
                    <div><p class="text-muted mb-1 small fw-bold">TOTAL SALDO KESELURUHAN</p><h3 class="fw-bold mb-0 text-primary">Rp <?php echo number_format((float)$t_saldo['total'],0,',','.'); ?></h3></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'template/footer.php'; ?>