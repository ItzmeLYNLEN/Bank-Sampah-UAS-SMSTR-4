<?php
session_start();
include '../../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../index.php");
    exit();
}

$aksi = $_GET['aksi'];

if($aksi == "tambah"){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $prefix = strtoupper(substr($nama, 0, 3));
    
    $query_id = mysqli_query($conn, "SELECT id_kategori FROM kategori_sampah WHERE id_kategori LIKE '$prefix-%' ORDER BY id_kategori DESC LIMIT 1");
    
    if (mysqli_num_rows($query_id) > 0) {
        $row = mysqli_fetch_assoc($query_id);
        $last_num = (int) substr($row['id_kategori'], -2);
        $new_num = $last_num + 1;
    } else {
        $new_num = 1;
    }
    
    $id_kategori_baru = $prefix . '-' . str_pad($new_num, 2, "0", STR_PAD_LEFT);
    
    mysqli_query($conn, "INSERT INTO kategori_sampah (id_kategori, nama_kategori, harga_per_kg) VALUES ('$id_kategori_baru', '$nama', '$harga')");
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