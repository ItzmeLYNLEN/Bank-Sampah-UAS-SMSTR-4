<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-t');
include 'template/header.php';
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h3 class="fw-bold">Laporan Transaksi</h3>
        <button onclick="window.print()" class="btn btn-primary fw-bold shadow-sm">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>
    <div class="card p-4 mb-4 no-print shadow-sm border-0">
        <form method="GET" action="laporan.php" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Dari Tanggal</label>
                <input type="date" name="tgl_awal" class="form-control" value="<?php echo $tgl_awal; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="form-control" value="<?php echo $tgl_akhir; ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100 fw-bold">Filter Data</button>
            </div>
        </form>
    </div>
    <div class="text-center mb-5 mt-4">
        <h3 class="fw-bold mb-1">REKAPITULASI BANK SAMPAH</h3>
        <p class="text-muted">Periode: <?php echo date('d M Y', strtotime($tgl_awal)); ?> - <?php echo date('d M Y', strtotime($tgl_akhir)); ?></p>
    </div>
    <div class="card p-4 mb-4 border-0 shadow-sm">
        <h5 class="fw-bold mb-3 text-success border-bottom pb-2">1. Laporan Setoran Sampah</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center small fw-bold">
                    <tr>
                        <th width="50">No</th>
                        <th width="120">Tanggal</th>
                        <th>Nama Nasabah</th>
                        <th>Rincian (Berat)</th>
                        <th width="150">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_masuk = 0;
                    $q_setoran = mysqli_query($conn, "SELECT s.tanggal_setor, n.nama_nasabah, GROUP_CONCAT(CONCAT(k.nama_kategori, ' (', d.berat_kg, ' Kg)') SEPARATOR '<br>') as rincian, s.total_seluruh_harga FROM setoran s JOIN nasabah n ON s.id_nasabah = n.id_nasabah JOIN detail_setoran d ON s.id_setoran = d.id_setoran JOIN kategori_sampah k ON d.id_kategori = k.id_kategori WHERE s.tanggal_setor BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY s.id_setoran ORDER BY s.tanggal_setor ASC");
                    while($s = mysqli_fetch_array($q_setoran)){
                        $total_masuk += $s['total_seluruh_harga'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center small"><?php echo $s['tanggal_setor']; ?></td>
                        <td><?php echo $s['nama_nasabah']; ?></td>
                        <td class="small text-muted"><?php echo $s['rincian']; ?></td>
                        <td class="text-end fw-bold text-success">Rp <?php echo number_format($s['total_seluruh_harga'],0,',','.'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="4" class="text-end">TOTAL PEMASUKAN</td>
                        <td class="text-end text-success">Rp <?php echo number_format($total_masuk,0,',','.'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card p-4 border-0 shadow-sm">
        <h5 class="fw-bold mb-3 text-danger border-bottom pb-2">2. Laporan Penarikan Tunai</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center small fw-bold">
                    <tr>
                        <th width="50">No</th>
                        <th width="120">Tanggal</th>
                        <th>Nama Nasabah</th>
                        <th width="150">Nominal Ditarik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_keluar = 0;
                    $q_penarikan = mysqli_query($conn, "SELECT p.tanggal_tarik, n.nama_nasabah, p.nominal_tarik as total FROM penarikan p JOIN nasabah n ON p.id_nasabah = n.id_nasabah WHERE p.tanggal_tarik BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.tanggal_tarik ASC");
                    while($p = mysqli_fetch_array($q_penarikan)){
                        $total_keluar += $p['total'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center small"><?php echo $p['tanggal_tarik']; ?></td>
                        <td><?php echo $p['nama_nasabah']; ?></td>
                        <td class="text-end fw-bold text-danger">Rp <?php echo number_format($p['total'],0,',','.'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">TOTAL PENGELUARAN</td>
                        <td class="text-end text-danger">Rp <?php echo number_format($total_keluar,0,',','.'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php include 'template/footer.php'; ?>