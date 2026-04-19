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
    $harga = $_POST['harga'];
    
    mysqli_query($conn, "INSERT INTO kategori_sampah (nama_kategori, harga_per_kg) VALUES ('$nama', '$harga')");
    header("location:katalog_sampah.php?status=sukses");

} else if($aksi == "edit"){
    $id = $_POST['id'];
    $harga = $_POST['harga'];
    
    mysqli_query($conn, "UPDATE kategori_sampah SET harga_per_kg='$harga' WHERE id_kategori='$id'");
    header("location:katalog_sampah.php?status=sukses");

} else if($aksi == "hapus"){
    $id = $_GET['id'];
    
    $cek = mysqli_query($conn, "SELECT * FROM detail_setoran WHERE id_kategori='$id'");
    
    if(mysqli_num_rows($cek) > 0){
        header("location:katalog_sampah.php?status=gagal_relasi");
    } else {
        mysqli_query($conn, "DELETE FROM kategori_sampah WHERE id_kategori='$id'");
        header("location:katalog_sampah.php?status=sukses");
    }
}
?>