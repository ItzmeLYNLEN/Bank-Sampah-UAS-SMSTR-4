<?php
session_start();
include '../../koneksi.php';

$id_n = $_POST['id_nasabah']; 
$id_k = $_POST['id_kategori']; 
$b = $_POST['berat']; 
$id_a = $_SESSION['id_admin']; 
$t = date('Y-m-d H:i:s');

$ymd = date('ymd');
$q_trx = mysqli_query($conn, "SELECT id_setoran FROM setoran WHERE id_setoran LIKE 'TRX-S-$ymd-%' ORDER BY id_setoran DESC LIMIT 1");

if(mysqli_num_rows($q_trx) > 0){
    $dt = mysqli_fetch_assoc($q_trx);
    $last_num = (int) substr($dt['id_setoran'], -3);
    $new_num = $last_num + 1;
} else {
    $new_num = 1;
}

$urutan_resi = str_pad($new_num, 3, "0", STR_PAD_LEFT);
$id_setoran_baru = 'TRX-S-' . $ymd . '-' . $urutan_resi;

$total = 0;
foreach($id_k as $key => $val){
    if($val != ""){
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$val'");
        $d = mysqli_fetch_assoc($q);
        $total += ($b[$key] * $d['harga_per_kg']);
    }
}

mysqli_query($conn, "INSERT INTO setoran (id_setoran, tanggal_setor, id_nasabah, total_seluruh_harga, id_admin) VALUES ('$id_setoran_baru', '$t', '$id_n', '$total', '$id_a')");

$item_ke = 1;
foreach($id_k as $key => $val){
    if($val != ""){
        $brt = $b[$key];
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$val'");
        $d = mysqli_fetch_assoc($q);
        $sub = $brt * $d['harga_per_kg'];
        $id_detail_baru = "4" . $ymd . $urutan_resi . str_pad($item_ke, 2, "0", STR_PAD_LEFT);
        mysqli_query($conn, "INSERT INTO detail_setoran (id_detail, id_setoran, id_kategori, berat_kg, subtotal_harga) VALUES ('$id_detail_baru', '$id_setoran_baru', '$val', '$brt', '$sub')");
        $item_ke++;
    }
}

mysqli_query($conn, "UPDATE nasabah SET saldo = saldo + $total WHERE id_nasabah='$id_n'");
header("location:setoran.php?status=sukses");
?>