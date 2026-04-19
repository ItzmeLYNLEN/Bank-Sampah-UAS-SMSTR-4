<?php
session_start(); 
include '../koneksi.php';

if($_SESSION['status_nasabah'] != "login"){ 
    header("location:../index.php?pesan=belum_login"); 
    exit(); 
}

include 'header.php';
?>
<div class="container-fluid">
    <div class="mb-4 text-center text-md-start">
        <h3 class="fw-bold">Katalog Harga</h3>
        <p class="text-muted small">Harga beli sampah per kilogram yang berlaku di wilayah Klapanunggal.</p>
    </div>

    <div class="row g-4">
        <?php 
        $q = mysqli_query($conn, "SELECT * FROM kategori_sampah"); 
        while($k = mysqli_fetch_array($q)){ 
        ?>
        <div class="col-lg-4 col-md-6 text-center">
            <div class="card p-4 shadow-sm h-100 border-0">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3 mx-auto" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-recycle text-success fa-3x"></i>
                </div>
                <h5 class="fw-bold mb-2"><?php echo $k['nama_kategori']; ?></h5>
                <div class="text-success fw-bold h4 mb-0">
                    Rp <?php echo number_format($k['harga_per_kg'],0,',','.'); ?> 
                    <span class="text-muted small fw-normal" style="font-size: 0.8rem;">/ kg</span>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php include 'footer.php'; ?>