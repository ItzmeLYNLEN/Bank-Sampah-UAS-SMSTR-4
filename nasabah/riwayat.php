<?php
session_start();
include '../koneksi.php';

if($_SESSION['status_nasabah'] != "login"){ 
    header("location:../index.php?pesan=belum_login"); 
    exit(); 
}

$id = $_SESSION['id_nasabah'];
include 'header.php';
?>
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Riwayat Transaksi</h3>
        <p class="text-muted small">Catatan seluruh aktivitas setoran dan penarikan saldo Anda.</p>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card p-4 border-0 shadow-sm mb-4">
                <h6 class="fw-bold text-success mb-3"><i class="fa-solid fa-arrow-down-long"></i> Tabungan Sampah (Masuk)</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light small fw-bold text-muted">
                            <tr>
                                <th width="150">Tanggal</th>
                                <th>Rincian Sampah</th>
                                <th class="text-end" width="180">Total Diterima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_setor = mysqli_query($conn, "SELECT s.tanggal_setor, GROUP_CONCAT(CONCAT(k.nama_kategori, ' (', d.berat_kg, ' Kg)') SEPARATOR '<br>') as rincian, s.total_seluruh_harga FROM setoran s JOIN detail_setoran d ON s.id_setoran = d.id_setoran JOIN kategori_sampah k ON d.id_kategori = k.id_kategori WHERE s.id_nasabah='$id' GROUP BY s.id_setoran ORDER BY s.tanggal_setor DESC");
                            while($s = mysqli_fetch_array($q_setor)){
                            ?>
                            <tr>
                                <td class="small"><?php echo date('d M Y', strtotime($s['tanggal_setor'])); ?></td>
                                <td class="small text-muted"><?php echo $s['rincian']; ?></td>
                                <td class="text-end fw-bold text-success">+ Rp <?php echo number_format($s['total_seluruh_harga'],0,',','.'); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card p-4 border-0 shadow-sm">
                <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-arrow-up-long"></i> Penarikan Tunai (Keluar)</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light small fw-bold text-muted">
                            <tr>
                                <th width="150">Tanggal</th>
                                <th class="text-end">Nominal Ditarik</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_tarik = mysqli_query($conn, "SELECT tanggal_tarik, SUM(nominal_tarik) as total FROM penarikan WHERE id_nasabah='$id' GROUP BY tanggal_tarik ORDER BY tanggal_tarik DESC");
                            while($p = mysqli_fetch_array($q_tarik)){
                            ?>
                            <tr>
                                <td class="small"><?php echo date('d M Y', strtotime($p['tanggal_tarik'])); ?></td>
                                <td class="text-end fw-bold text-danger">- Rp <?php echo number_format($p['total'],0,',','.'); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>