<?php
session_start();
include 'koneksi.php';
$username_hp = $_POST['username_hp'];
$password = $_POST['password'];
$cek_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username_hp' AND password='$password'");
if(mysqli_num_rows($cek_admin) > 0){
    $admin = mysqli_fetch_assoc($cek_admin);
    $_SESSION['username'] = $admin['username'];
    $_SESSION['id_admin'] = $admin['id_admin'];
    $_SESSION['status'] = "login";
    header("location:admin/");
    exit();
}
$cek_nasabah = mysqli_query($conn, "SELECT * FROM nasabah WHERE no_hp='$username_hp' AND password='$password'");
if(mysqli_num_rows($cek_nasabah) > 0){
    $nasabah = mysqli_fetch_assoc($cek_nasabah);
    $_SESSION['id_nasabah'] = $nasabah['id_nasabah'];
    $_SESSION['nama_nasabah'] = $nasabah['nama_nasabah'];
    $_SESSION['status_nasabah'] = "login";
    header("location:nasabah/");
    exit();
}
header("location:index.php?pesan=gagal");
?>