</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const currentPath = window.location.pathname.split("/").pop();
    document.querySelectorAll('.nav-link').forEach(link => {
        if(link.getAttribute('href') === currentPath || (currentPath === "" && link.getAttribute('href') === "index.php")) { 
            link.classList.add('active'); 
        }
    });

    const btnToggle = document.getElementById('toggleSidebar');
    const sidebarElement = document.getElementById('sidebar');

    if(btnToggle) { 
        btnToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebarElement.classList.toggle('active');
        }); 
    }

    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebarElement.contains(event.target);
        const isClickInsideBtn = btnToggle ? btnToggle.contains(event.target) : false;

        if (!isClickInsideSidebar && !isClickInsideBtn && sidebarElement.classList.contains('active')) {
            sidebarElement.classList.remove('active');
        }
    });

    function konfirmasiLogout() {
        Swal.fire({
            title: 'Ingin keluar?',
            text: "Anda perlu login kembali untuk melihat saldo.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php';
            }
        })
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>