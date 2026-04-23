<?php
session_start();
include '../../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../index.php?pesan=belum_login");
    exit();
}

include '../template/header.php';
?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="mb-4 text-danger">
        <h3 class="fw-bold">Penarikan Tunai</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0">
                <form method="POST" action="penarikan_proses.php">
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Cari & Pilih Nasabah</label>
                        <select id="cari-nasabah" name="id_nasabah" placeholder="Ketik nama nasabah..." autocomplete="off" required>
                            <option value="">Ketik nama nasabah...</option>
                            <?php
                            $n = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY nama_nasabah ASC");
                            while($dn = mysqli_fetch_array($n)){
                                echo "<option value='".$dn['id_nasabah']."'>".$dn['nama_nasabah']." (Saldo: Rp ".number_format($dn['saldo'],0,',','.').")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Nominal Penarikan (Rp)</label>
                        <input type="number" name="nominal" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold">Konfirmasi Penarikan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#cari-nasabah", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pesan') === 'saldo_kurang') { 
        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Saldo tidak mencukupi!', confirmButtonColor: '#d33' }); 
    } else if (urlParams.get('status') === 'sukses') { 
        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Penarikan sukses!', confirmButtonColor: '#198754' }); 
    }
</script>

<?php include '../template/footer.php'; ?>