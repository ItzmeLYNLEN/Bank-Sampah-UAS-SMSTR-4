<?php
session_start();
include '../../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../index.php?pesan=belum_login");
    exit();
}

$opsi_kategori = "<option value=''>-- Pilih Sampah --</option>";
$k = mysqli_query($conn, "SELECT * FROM kategori_sampah");
while($dk = mysqli_fetch_array($k)){
    $opsi_kategori .= "<option value='".$dk['id_kategori']."'>".$dk['nama_kategori']." (Rp ".number_format($dk['harga_per_kg'],0,',','.')."/kg)</option>";
}

include '../template/header.php';
?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-success"><i class="fa-solid fa-circle-plus"></i> Input Setoran Baru</h3>
        <p class="text-muted">Masukkan data sampah yang dibawa oleh nasabah.</p>
    </div>

    <div class="card p-4 shadow-sm border-0">
        <form method="POST" action="setoran_proses.php">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Nama Nasabah</label>
                    <select name="id_nasabah" class="form-select form-select-lg" required>
                        <option value="">-- Pilih Nasabah --</option>
                        <?php
                        $n = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY nama_nasabah ASC");
                        while($dn = mysqli_fetch_array($n)){
                            echo "<option value='".$dn['id_nasabah']."'>".$dn['nama_nasabah']." (Saldo: Rp ".number_format($dn['saldo'],0,',','.').")</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabelSampah">
                    <thead class="table-dark text-center small">
                        <tr>
                            <th>Jenis Sampah</th>
                            <th width="200">Berat (Kg)</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="id_kategori[]" class="form-select" required>
                                    <?php echo $opsi_kategori; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="berat[]" class="form-control" placeholder="0.00" required>
                            </td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-success btn-sm fw-bold" onclick="tambahBaris()">
                    <i class="fa-solid fa-plus"></i> Tambah Jenis Sampah
                </button>
                <button type="submit" class="btn btn-success px-5 fw-bold shadow">
                    SIMPAN TRANSAKSI
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahBaris() {
        var table = document.getElementById("tabelSampah").getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.innerHTML = `
            <td>
                <select name="id_kategori[]" class="form-select" required><?php echo $opsi_kategori; ?></select>
            </td>
            <td>
                <input type="number" step="0.01" name="berat[]" class="form-control" placeholder="0.00" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;
    }

    function hapusBaris(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'sukses') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Transaksi setoran telah dicatat!',
            confirmButtonColor: '#198754'
        });
    } else if (urlParams.get('status') === 'gagal') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Terjadi kesalahan saat menyimpan transaksi.',
            confirmButtonColor: '#d33'
        });
    }
</script>

<?php include '../template/footer.php'; ?>