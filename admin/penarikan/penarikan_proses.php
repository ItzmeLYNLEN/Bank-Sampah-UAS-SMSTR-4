<?php
session_start();
include '../../koneksi.php';

$id_nasabah = $_POST['id_nasabah'];
$nominal = $_POST['nominal'];
$id_admin = $_SESSION['id_admin'];
$tanggal = date('Y-m-d');

$cek = mysqli_query($conn, "SELECT saldo FROM nasabah WHERE id_nasabah='$id_nasabah'");
$data = mysqli_fetch_assoc($cek);

if($nominal > $data['saldo']){
    header("location:penarikan.php?pesan=saldo_kurang");
} else {
    mysqli_query($conn, "INSERT INTO penarikan (tanggal_tarik, id_nasabah, nominal_tarik, id_admin) VALUES ('$tanggal', '$id_nasabah', '$nominal', '$id_admin')");
    mysqli_query($conn, "UPDATE nasabah SET saldo = saldo - $nominal WHERE id_nasabah='$id_nasabah'");
    
    header("location:penarikan.php?status=sukses");
}
?>