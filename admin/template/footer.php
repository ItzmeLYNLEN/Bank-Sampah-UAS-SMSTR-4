</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    if(toggleBtn) { toggleBtn.addEventListener('click', () => { sidebar.classList.toggle('active'); }); }
    const currentPath = window.location.pathname.split("/").pop();
    document.querySelectorAll('.nav-link').forEach(link => {
        if(link.getAttribute('href') === currentPath || (currentPath === "" && link.getAttribute('href') === "index.php")) { link.classList.add('active'); }
    });
    function konfirmasiLogout() {
        Swal.fire({ title: 'Yakin ingin keluar?', icon: 'question', showCancelButton: true, confirmButtonColor: '#198754', cancelButtonColor: '#d33', confirmButtonText: 'Ya, Keluar!' }).then((result) => {
            if (result.isConfirmed) { window.location.href = 'logout.php'; }
        })
    }
</script>
</body>
</html>