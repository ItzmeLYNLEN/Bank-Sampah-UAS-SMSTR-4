<?php
session_start();
include '../../koneksi.php';
$id_n = $_POST['id_nasabah']; $id_k = $_POST['id_kategori']; $b = $_POST['berat']; $id_a = $_SESSION['id_admin']; 
$t = date('Y-m-d H:i:s');
$total = 0;
foreach($id_k as $key => $val){
    if($val != ""){
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$val'");
        $d = mysqli_fetch_assoc($q);
        $total += ($b[$key] * $d['harga_per_kg']);
    }
}
mysqli_query($conn, "INSERT INTO setoran (tanggal_setor, id_nasabah, total_seluruh_harga, id_admin) VALUES ('$t', '$id_n', '$total', '$id_a')");
$id_s = mysqli_insert_id($conn);
foreach($id_k as $key => $val){
    if($val != ""){
        $brt = $b[$key];
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$val'");
        $d = mysqli_fetch_assoc($q);
        $sub = $brt * $d['harga_per_kg'];
        mysqli_query($conn, "INSERT INTO detail_setoran (id_setoran, id_kategori, berat_kg, subtotal_harga) VALUES ('$id_s', '$val', '$brt', '$sub')");
    }
}
mysqli_query($conn, "UPDATE nasabah SET saldo = saldo + $total WHERE id_nasabah='$id_n'");
header("location:setoran.php?status=sukses");
?>