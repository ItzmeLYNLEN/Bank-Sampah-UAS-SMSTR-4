<?php
session_start();
include '../../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../../index.php?pesan=belum_login");
    exit();
}

include '../template/header.php';
?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Master Katalog Sampah</h3>
        <p class="text-muted small">Kelola jenis sampah dan perbarui harga beli per kilogram.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-3">Tambah Jenis Baru</h5>
                <form method="POST" action="katalog_aksi.php?aksi=tambah">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Sampah</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Tembaga" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Harga per Kg (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="0" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold">Simpan Katalog</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card p-4 shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Sampah</th>
                                <th>Harga / Kg</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($conn, "SELECT * FROM kategori_sampah ORDER BY nama_kategori ASC");
                            while($row = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td class="fw-bold"><?php echo $row['nama_kategori']; ?></td>
                                <td class="text-success fw-bold">Rp <?php echo number_format($row['harga_per_kg'],0,',','.'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id_kategori']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="konfirmasiHapus('<?php echo $row['id_kategori']; ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?php echo $row['id_kategori']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Edit Harga: <?php echo $row['nama_kategori']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="katalog_aksi.php?aksi=edit">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $row['id_kategori']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Harga Baru (Rp)</label>
                                                    <input type="number" name="harga" class="form-control" value="<?php echo $row['harga_per_kg']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-sm px-4">Update Harga</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Katalog?',
            text: "Pastikan data ini belum pernah digunakan dalam transaksi apapun.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "katalog_aksi.php?aksi=hapus&id=" + id;
            }
        })
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'sukses') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data katalog telah diperbarui!',
            confirmButtonColor: '#198754'
        });
    } else if (urlParams.get('status') === 'gagal_relasi') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Hapus',
            text: 'Sampah ini sudah memiliki riwayat transaksi dan tidak bisa dihapus.',
            confirmButtonColor: '#d33'
        });
    }
</script>

<?php include '../template/footer.php'; ?>