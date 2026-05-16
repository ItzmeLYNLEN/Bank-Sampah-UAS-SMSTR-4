<?php
session_start();
include '../koneksi.php';
if($_SESSION['status'] != "login"){ header("location:../index.php?pesan=belum_login"); exit(); }

if(isset($_POST['tambah'])){
    $nama = $_POST['nama_admin'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query_id = mysqli_query($conn, "SELECT MAX(id_admin) as id_max FROM admin");
    $data_id = mysqli_fetch_assoc($query_id);
    $id_max = $data_id['id_max'];
    if($id_max){
        $urutan = (int) substr($id_max, 4, 3);
        $urutan++;
    } else {
        $urutan = 1;
    }
    $id_baru = "ADM-" . sprintf("%03s", $urutan);

    mysqli_query($conn, "INSERT INTO admin (id_admin, nama_admin, username, password) VALUES ('$id_baru', '$nama', '$username', '$password')");
    header("location:data_admin.php?pesan=tambah");
    exit();
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM admin WHERE id_admin='$id'");
    header("location:data_admin.php?pesan=hapus");
    exit();
}

if(isset($_POST['edit'])){
    $id = $_POST['id_admin'];
    $nama = $_POST['nama_admin'];
    $username = $_POST['username'];
    if(!empty($_POST['password'])){
        $password = $_POST['password'];
        mysqli_query($conn, "UPDATE admin SET nama_admin='$nama', username='$username', password='$password' WHERE id_admin='$id'");
    } else {
        mysqli_query($conn, "UPDATE admin SET nama_admin='$nama', username='$username' WHERE id_admin='$id'");
    }
    header("location:data_admin.php?pesan=edit");
    exit();
}

include 'template/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Data Admin / Petugas</h3>
            <p class="text-muted small">Kelola hak akses pengguna sistem informasi.</p>
        </div>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa-solid fa-user-plus me-2"></i>Tambah Admin</button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle w-100 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-center" style="width: 5%">No</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">Username</th>
                            <th class="px-4 py-3 text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM admin ORDER BY id_admin DESC");
                        while($data = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td class="px-4 text-center"><?php echo $no++; ?></td>
                            <td class="px-4 fw-bold"><?php echo $data['nama_admin']; ?></td>
                            <td class="px-4"><span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2"><?php echo $data['username']; ?></span></td>
                            <td class="px-4 text-center">
                                <button class="btn btn-sm btn-warning text-white me-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $data['id_admin']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <a href="#" class="btn btn-sm btn-danger btn-hapus" data-href="data_admin.php?hapus=<?php echo $data['id_admin']; ?>"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?php echo $data['id_admin']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Edit Data Admin</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_admin" value="<?php echo $data['id_admin']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                                <input type="text" name="nama_admin" class="form-control" value="<?php echo $data['nama_admin']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Username</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Password Baru</label>
                                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_admin" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if(isset($_GET['pesan'])): ?>
    let pesan = "<?php echo $_GET['pesan']; ?>";
    let teks = "";
    if(pesan == 'tambah') teks = "Data admin berhasil ditambahkan!";
    if(pesan == 'edit') teks = "Data admin berhasil diperbarui!";
    if(pesan == 'hapus') teks = "Data admin berhasil dihapus!";
    
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: teks,
        timer: 2000,
        showConfirmButton: false
    });
<?php endif; ?>

document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('data-href');
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data admin ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>