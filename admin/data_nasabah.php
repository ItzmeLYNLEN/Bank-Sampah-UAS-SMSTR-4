<?php
session_start();
include '../koneksi.php';

if($_SESSION['status'] != "login"){
    header("location:../index.php?pesan=belum_login");
    exit();
}

include 'header.php';
?>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Data Nasabah</h3>
        <p class="text-muted small">Kelola informasi akun dan saldo warga.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-3">Tambah Nasabah Baru</h5>
                <form method="POST" action="nasabah_aksi.php?aksi=tambah">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold">Simpan Nasabah</button>
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
                                <th>Nasabah</th>
                                <th>No. HP</th>
                                <th>Saldo</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY nama_nasabah ASC");
                            while($row = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo $row['nama_nasabah']; ?></div>
                                    <div class="small text-muted"><?php echo $row['alamat']; ?></div>
                                </td>
                                <td><?php echo $row['no_hp']; ?></td>
                                <td class="fw-bold text-success">Rp <?php echo number_format($row['saldo'],0,',','.'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editNasabah<?php echo $row['id_nasabah']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="konfirmasiHapusNasabah(<?php echo $row['id_nasabah']; ?>)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editNasabah<?php echo $row['id_nasabah']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Edit Data Nasabah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="nasabah_aksi.php?aksi=edit">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $row['id_nasabah']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $row['nama_nasabah']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Alamat</label>
                                                    <textarea name="alamat" class="form-control" rows="2" required><?php echo $row['alamat']; ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">No. HP</label>
                                                    <input type="text" name="no_hp" class="form-control" value="<?php echo $row['no_hp']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">Password Baru</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-sm px-4">Update Data</button>
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
    function konfirmasiHapusNasabah(id) {
        Swal.fire({
            title: 'Hapus Nasabah?',
            text: "Data transaksi nasabah ini juga akan diperiksa sebelum penghapusan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "nasabah_aksi.php?aksi=hapus&id=" + id;
            }
        })
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'sukses') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data nasabah telah diperbarui!',
            confirmButtonColor: '#198754'
        });
    } else if (urlParams.get('status') === 'gagal_transaksi') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Hapus',
            text: 'Nasabah ini masih memiliki riwayat transaksi setoran atau penarikan!',
            confirmButtonColor: '#d33'
        });
    }
</script>

<?php include 'footer.php'; ?>