<?php
session_start();
include '../../koneksi.php';

$id_nasabah = $_POST['id_nasabah'];
$id_kategori_array = $_POST['id_kategori'];
$berat_array = $_POST['berat'];
$id_admin = $_SESSION['id_admin'];
$tanggal = date('Y-m-d');

$total_seluruh_harga = 0;

foreach($id_kategori_array as $key => $id_kat){
    if($id_kat != ""){
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$id_kat'");
        $d = mysqli_fetch_assoc($q);
        $total_seluruh_harga += ($berat_array[$key] * $d['harga_per_kg']);
    }
}

mysqli_query($conn, "INSERT INTO setoran (tanggal_setor, id_nasabah, total_seluruh_harga, id_admin) VALUES ('$tanggal', '$id_nasabah', '$total_seluruh_harga', '$id_admin')");

$id_setoran_induk = mysqli_insert_id($conn);

foreach($id_kategori_array as $key => $id_kat){
    if($id_kat != ""){
        $berat_item = $berat_array[$key];
        $q = mysqli_query($conn, "SELECT harga_per_kg FROM kategori_sampah WHERE id_kategori='$id_kat'");
        $d = mysqli_fetch_assoc($q);
        $subtotal = $berat_item * $d['harga_per_kg'];

        mysqli_query($conn, "INSERT INTO detail_setoran (id_setoran, id_kategori, berat_kg, subtotal_harga) VALUES ('$id_setoran_induk', '$id_kat', '$berat_item', '$subtotal')");
    }
}

mysqli_query($conn, "UPDATE nasabah SET saldo = saldo + $total_seluruh_harga WHERE id_nasabah='$id_nasabah'");

header("location:setoran.php?status=sukses");
?>