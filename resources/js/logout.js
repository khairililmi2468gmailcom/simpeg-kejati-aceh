document.addEventListener("DOMContentLoaded", function() {
    const logoutBtn = document.getElementById("logoutBtn");
    const logoutForm = document.getElementById("logoutForm");

    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener("click", function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin logout?',
                text: "Anda akan keluar dari dashboard.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00A180',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutForm.submit(); // Hanya submit form logout
                }
            });
        });
    }

    // Menampilkan SweetAlert jika logout berhasil
    @if (session('logout_success'))
        Swal.fire({
            icon: 'success',
            title: 'Logout Berhasil',
            text: "{{ session('logout_success') }}",
            confirmButtonColor: '#00A180'
        });
    @elseif (session('logout_failed'))
        Swal.fire({
            icon: 'error',
            title: 'Logout Gagal',
            text: "{{ session('logout_failed') }}",
            confirmButtonColor: '#00A180'
        });
    @endif
});
