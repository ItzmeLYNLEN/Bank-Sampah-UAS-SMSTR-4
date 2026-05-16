<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }

$nasabah = mysqli_query($conn, "SELECT COUNT(*) as total FROM nasabah");
$t_nasabah = mysqli_fetch_assoc($nasabah);
$saldo = mysqli_query($conn, "SELECT SUM(saldo) as total FROM nasabah");
$t_saldo = mysqli_fetch_assoc($saldo);

$b_sekarang = date('m');
$tahun_sekarang = date('Y');

$q_masuk = mysqli_query($conn, "SELECT SUM(total_seluruh_harga) as total FROM setoran WHERE MONTH(tanggal_setor)='$b_sekarang' AND YEAR(tanggal_setor)='$tahun_sekarang'");
$t_masuk = mysqli_fetch_assoc($q_masuk);

$q_keluar = mysqli_query($conn, "SELECT SUM(nominal_tarik) as total FROM penarikan WHERE MONTH(tanggal_tarik)='$b_sekarang' AND YEAR(tanggal_tarik)='$tahun_sekarang'");
$t_keluar = mysqli_fetch_assoc($q_keluar);

$data_per_bulan = array_fill_keys(range(1, 12), 0);

$chart_query = mysqli_query($conn, "SELECT MONTH(tanggal_setor) as bulan_angka, SUM(total_seluruh_harga) as total FROM setoran WHERE YEAR(tanggal_setor) = '$tahun_sekarang' GROUP BY MONTH(tanggal_setor)");

while($row = mysqli_fetch_assoc($chart_query)){
    $bulan_int = (int)$row['bulan_angka'];
    $data_per_bulan[$bulan_int] = (float) $row['total'];
}

$label_tgl = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$data_setoran = array_values($data_per_bulan);

include 'template/header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard Admin</h3>
        <p class="text-muted small">Statistik sistem dan tren transaksi terkini.</p>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">JUMLAH NASABAH</h6>
                    <p class="card-text fs-4 fw-bold mb-0"><?php echo $t_nasabah['total']; ?> Orang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">SALDO KESELURUHAN</h6>
                    <p class="card-text fs-4 fw-bold mb-0">Rp <?php echo number_format((float)$t_saldo['total'],0,',','.'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">SETORAN BULAN INI</h6>
                    <p class="card-text fs-4 fw-bold mb-0">Rp <?php echo number_format((float)$t_masuk['total'],0,',','.'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">PENARIKAN BULAN INI</h6>
                    <p class="card-text fs-4 fw-bold mb-0">Rp <?php echo number_format((float)$t_keluar['total'],0,',','.'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-4">Grafik Pemasukan Setoran (Tahun <?php echo $tahun_sekarang; ?>)</h5>
                <div>
                    <canvas id="setoranChart" style="height: 320px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const ctx = document.getElementById('setoranChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($label_tgl); ?>,
            datasets: [{
                label: 'Total Setoran',
                data: <?php echo json_encode($data_setoran); ?>,
                backgroundColor: 'rgba(13, 110, 253, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                } 
            }
        }
    });
</script>
<?php include 'template/footer.php'; ?>