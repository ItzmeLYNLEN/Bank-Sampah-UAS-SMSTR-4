<?php
session_start();
include '../../koneksi.php';

$id_n = $_POST['id_nasabah']; 
$nominal = $_POST['nominal']; 
$id_a = $_SESSION['id_admin']; 
$t = date('Y-m-d H:i:s');


$ymd = date('ymd'); // Format: 260428
$q_trx = mysqli_query($conn, "SELECT id_penarikan FROM penarikan WHERE id_penarikan LIKE 'TRX-P-$ymd-%' ORDER BY id_penarikan DESC LIMIT 1");

if(mysqli_num_rows($q_trx) > 0){
    $dt = mysqli_fetch_assoc($q_trx);
    $last_num = (int) substr($dt['id_penarikan'], -3);
    $new_num = $last_num + 1;
} else {
    $new_num = 1;
}

$urutan_resi = str_pad($new_num, 3, "0", STR_PAD_LEFT);
$id_penarikan_baru = 'TRX-P-' . $ymd . '-' . $urutan_resi;



$q_saldo = mysqli_query($conn, "SELECT saldo FROM nasabah WHERE id_nasabah='$id_n'");
$d_saldo = mysqli_fetch_assoc($q_saldo);

if($d_saldo['saldo'] < $nominal){
    // Jika saldo tidak cukup
    header("location:penarikan.php?status=gagal_saldo");
} else {

    mysqli_query($conn, "INSERT INTO penarikan (id_penarikan, tanggal_tarik, id_nasabah, nominal_tarik, id_admin) VALUES ('$id_penarikan_baru', '$t', '$id_n', '$nominal', '$id_a')");
    

    mysqli_query($conn, "UPDATE nasabah SET saldo = saldo - $nominal WHERE id_nasabah='$id_n'");
    
    header("location:penarikan.php?status=sukses");
}
?>