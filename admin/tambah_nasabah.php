<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password'];

mysqli_query($conn, "INSERT INTO nasabah (nama_nasabah, alamat, no_hp, password, saldo) VALUES ('$nama', '$alamat', '$no_hp', '$password', '0')");

header("location:data_nasabah.php");
?>