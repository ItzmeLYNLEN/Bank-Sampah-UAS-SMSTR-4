<?php
session_start();
include '../koneksi.php';
if($_SESSION['status_nasabah'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }

$id = $_SESSION['id_nasabah'];
$q = mysqli_query($conn, "SELECT saldo FROM nasabah WHERE id_nasabah='$id'");
$r = mysqli_fetch_assoc($q);

$label_sampah = [];
$data_berat = [];
$kat_query = mysqli_query($conn, "SELECT k.nama_kategori, SUM(d.berat_kg) as total_berat FROM detail_setoran d JOIN setoran s ON d.id_setoran = s.id_setoran JOIN kategori_sampah k ON d.id_kategori = k.id_kategori WHERE s.id_nasabah = '$id' GROUP BY k.nama_kategori");

while($row = mysqli_fetch_assoc($kat_query)){
    $label_sampah[] = $row['nama_kategori'];
    $data_berat[] = $row['total_berat'];
}

include 'header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Beranda Nasabah</h3>
        <p class="text-muted">Halo, <?php echo $_SESSION['nama_nasabah']; ?>! Pantau kontribusi anda.</p>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card balance-card p-4 h-100 d-flex flex-column justify-content-center">
                <p class="mb-1 opacity-75 fw-medium small text-uppercase">Total Saldo Anda</p>
                <h1 class="display-5 fw-bold mb-0">Rp <?php echo number_format($r['saldo'],0,',','.'); ?></h1>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 h-100 shadow-sm border-0 border-start border-4 border-success">
                <h5 class="fw-bold">Statistik Sampah (Kg)</h5>
                <div style="max-height: 200px; display: flex; justify-content: center;">
                    <canvas id="sampahChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('sampahChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($label_sampah); ?>,
            datasets: [{
                data: <?php echo json_encode($data_berat); ?>,
                backgroundColor: ['#198754', '#20c997', '#ffc107', '#0dcaf0', '#6610f2']
            }]
        },
        options: { responsive: true }
    });
</script>
<?php include 'footer.php'; ?>