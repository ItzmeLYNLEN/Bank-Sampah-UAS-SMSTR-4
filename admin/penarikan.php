<?php
session_start(); include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }
include 'header.php';
?>
<div class="container-fluid">
    <div class="mb-4 text-danger"><h3 class="fw-bold">Penarikan Tunai</h3></div>
    <div class="row justify-content-center"><div class="col-md-6"><div class="card p-4 shadow-sm">
        <form method="POST" action="penarikan_proses.php">
            <div class="mb-3"><label class="form-label fw-bold small">Pilih Nasabah</label><select name="id_nasabah" class="form-select" required><option value="">-- Pilih --</option><?php $n=mysqli_query($conn,"SELECT * FROM nasabah"); while($dn=mysqli_fetch_array($n)){ echo "<option value='".$dn['id_nasabah']."'>".$dn['nama_nasabah']." (Saldo: Rp ".number_format($dn['saldo'],0,',','.').")</option>"; } ?></select></div>
            <div class="mb-3"><label class="form-label fw-bold small">Nominal (Rp)</label><input type="number" name="nominal" class="form-control" required></div>
            <button type="submit" class="btn btn-danger w-100 fw-bold">Konfirmasi Penarikan</button>
        </form>
    </div></div></div>
</div>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pesan') === 'saldo_kurang') { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Saldo tidak mencukupi!', confirmButtonColor: '#d33' }); }
    else if (urlParams.get('status') === 'sukses') { Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Penarikan sukses!', confirmButtonColor: '#198754' }); }
</script>
<?php include 'footer.php'; ?>