<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ exit(); }

$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Bank_Sampah_".$tgl_awal."_".$tgl_akhir.".xls");
?>
<h3>REKAPITULASI BANK SAMPAH</h3>
<p>Periode: <?php echo $tgl_awal; ?> s/d <?php echo $tgl_akhir; ?></p>

<table border="1">
    <tr>
        <th colspan="5">LAPORAN SETORAN</th>
    </tr>
    <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Nasabah</th>
        <th>Rincian</th>
        <th>Total</th>
    </tr>
    <?php
    $no = 1; $total_m = 0;
    $q = mysqli_query($conn, "SELECT s.tanggal_setor, n.nama_nasabah, GROUP_CONCAT(CONCAT(k.nama_kategori, ' (', d.berat_kg, ' Kg)') SEPARATOR '; ') as rin, s.total_seluruh_harga FROM setoran s JOIN nasabah n ON s.id_nasabah = n.id_nasabah JOIN detail_setoran d ON s.id_setoran = d.id_setoran JOIN kategori_sampah k ON d.id_kategori = k.id_kategori WHERE s.tanggal_setor BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59' GROUP BY s.id_setoran");
    while($s = mysqli_fetch_array($q)){
        $total_m += $s['total_seluruh_harga'];
        echo "<tr><td>".$no++."</td><td>".$s['tanggal_setor']."</td><td>".$s['nama_nasabah']."</td><td>".$s['rin']."</td><td>".$s['total_seluruh_harga']."</td></tr>";
    }
    ?>
    <tr><td colspan="4">TOTAL PEMASUKAN</td><td><?php echo $total_m; ?></td></tr>
</table>

<br>

<table border="1">
    <tr>
        <th colspan="4">LAPORAN PENARIKAN</th>
    </tr>
    <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Nasabah</th>
        <th>Nominal</th>
    </tr>
    <?php
    $no = 1; $total_k = 0;
    $q = mysqli_query($conn, "SELECT p.tanggal_tarik, n.nama_nasabah, p.nominal_tarik FROM penarikan p JOIN nasabah n ON p.id_nasabah = n.id_nasabah WHERE p.tanggal_tarik BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59'");
    while($p = mysqli_fetch_array($q)){
        $total_k += $p['nominal_tarik'];
        echo "<tr><td>".$no++."</td><td>".$p['tanggal_tarik']."</td><td>".$p['nama_nasabah']."</td><td>".$p['nominal_tarik']."</td></tr>";
    }
    ?>
    <tr><td colspan="3">TOTAL PENGELUARAN</td><td><?php echo $total_k; ?></td></tr>
</table>