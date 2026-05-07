    </div> <!-- End Container -->
    <footer class="text-center py-5 mt-5" style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: 6rem !important;">
        <h4 style="font-family: 'Playfair Display', serif; color: var(--accent-gold); letter-spacing: 2px;">GRAND HOTEL</h4>
        <p class="mb-0 mt-3" style="color: var(--text-muted); font-size: 0.85rem; letter-spacing: 1px;">&copy; <?= date('Y'); ?>. EXCELENCIA Y CONFORT.</p>
    </footer>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Reemplazar confirm() nativo con SweetAlert2 Dark Theme
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                Swal.fire({
                    title: '¿Confirmar eliminación?',
                    text: "Esta acción es irreversible.",
                    icon: 'warning',
                    background: '#151e32',
                    color: '#f8fafc',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: 'transparent',
                    confirmButtonText: 'ELIMINAR',
                    cancelButtonText: 'CANCELAR',
                    customClass: {
                        cancelButton: 'border border-secondary text-white'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</body>
</html>
