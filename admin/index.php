<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }

$nasabah = mysqli_query($conn, "SELECT COUNT(*) as total FROM nasabah");
$t_nasabah = mysqli_fetch_assoc($nasabah);
$saldo = mysqli_query($conn, "SELECT SUM(saldo) as total FROM nasabah");
$t_saldo = mysqli_fetch_assoc($saldo);

$label_tgl = [];
$data_setoran = [];
$tgl_7_hari = date('Y-m-d', strtotime('-6 days'));
$chart_query = mysqli_query($conn, "SELECT DATE(tanggal_setor) as tgl, SUM(total_seluruh_harga) as total FROM setoran WHERE tanggal_setor >= '$tgl_7_hari' GROUP BY DATE(tanggal_setor) ORDER BY tgl ASC");

while($row = mysqli_fetch_assoc($chart_query)){
    $label_tgl[] = date('d M', strtotime($row['tgl']));
    $data_setoran[] = $row['total'];
}

include 'template/header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Admin</h3>
        <p class="text-muted small">Statistik sistem dan tren transaksi terkini.</p>
    </div>
    <div class="row g-4 mb-4">
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
                    <div><p class="text-muted mb-1 small fw-bold">SALDO KESELURUHAN</p><h3 class="fw-bold mb-0 text-primary">Rp <?php echo number_format((float)$t_saldo['total'],0,',','.'); ?></h3></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-4">Tren Setoran (7 Hari Terakhir)</h5>
                <canvas id="setoranChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('setoranChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($label_tgl); ?>,
            datasets: [{
                label: 'Total Setoran (Rp)',
                data: <?php echo json_encode($data_setoran); ?>,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
<?php include 'template/footer.php'; ?>