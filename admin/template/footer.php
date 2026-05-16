</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const btnT = document.getElementById('toggleSidebar');
    const sideE = document.getElementById('sidebar');
    if(btnT) { btnT.addEventListener('click', (e) => { e.preventDefault(); sideE.classList.toggle('active'); }); }
    
    const path = window.location.pathname.split("/").pop();
    document.querySelectorAll('.nav-link').forEach(l => { 
        const hrefPath = l.getAttribute('href').split("/").pop();
        if(hrefPath === path || (path === "" && hrefPath === "index.php")) { 
            l.classList.add('active'); 
        } 
    });
    
    function konfirmasiLogout(url) {
        Swal.fire({ title: 'Yakin keluar?', icon: 'question', showCancelButton: true, confirmButtonColor: '#198754', cancelButtonColor: '#d33', confirmButtonText: 'Ya' }).then((r) => { 
            if (r.isConfirmed) { window.location.href = url; } 
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('.table:not(#tabelSampah)').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>