<?php
session_start();
include '../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../index.php");
    exit();
}

$aksi = $_GET['aksi'];

if($aksi == "tambah"){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];

    mysqli_query($conn, "INSERT INTO nasabah (nama_nasabah, alamat, no_hp, password, saldo) VALUES ('$nama', '$alamat', '$no_hp', '$password', '0')");
    header("location:data_nasabah.php?status=sukses");

} else if($aksi == "edit"){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];

    if(empty($password)){
        mysqli_query($conn, "UPDATE nasabah SET nama_nasabah='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id_nasabah='$id'");
    } else {
        mysqli_query($conn, "UPDATE nasabah SET nama_nasabah='$nama', alamat='$alamat', no_hp='$no_hp', password='$password' WHERE id_nasabah='$id'");
    }
    header("location:data_nasabah.php?status=sukses");

} else if($aksi == "hapus"){
    $id = $_GET['id'];

    $cek_setoran = mysqli_query($conn, "SELECT * FROM setoran WHERE id_nasabah='$id'");
    $cek_penarikan = mysqli_query($conn, "SELECT * FROM penarikan WHERE id_nasabah='$id'");

    if(mysqli_num_rows($cek_setoran) > 0 || mysqli_num_rows($cek_penarikan) > 0){
        header("location:data_nasabah.php?status=gagal_transaksi");
    } else {
        mysqli_query($conn, "DELETE FROM nasabah WHERE id_nasabah='$id'");
        header("location:data_nasabah.php?status=sukses");
    }
}
?>