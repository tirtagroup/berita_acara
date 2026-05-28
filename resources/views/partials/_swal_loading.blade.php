{{--
  Global SweetAlert2 loading overlay untuk modul BA / PICA / Assessment.

  Cara kerja:
    - SweetAlert2 di-load dari CDN (hanya sekali per halaman).
    - Auto-attach ke semua <form> non-GET pada URL yang match pola modul.
    - Skip form yang punya atribut `data-no-swal`.
    - Expose helper global:
        window.swalLoading(title?)   → tampilkan overlay manual (dipakai AJAX)
        window.swalClose()           → tutup overlay
        window.swalSuccess(msg)      → toast sukses
        window.swalError(msg)        → toast error

  Untuk skip per-form tambahkan: <form data-no-swal>
--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
(function () {
  if (typeof Swal === 'undefined') return;

  // ---- Helper publik --------------------------------------------------------
  window.swalLoading = function (title) {
    Swal.fire({
      title: title || 'Memproses...',
      html: 'Mohon tunggu sebentar.',
      allowOutsideClick: false,
      allowEscapeKey: false,
      showConfirmButton: false,
      didOpen: () => Swal.showLoading(),
    });
  };
  window.swalClose = function () { Swal.close(); };
  window.swalSuccess = function (msg) {
    Swal.fire({ icon: 'success', title: msg || 'Berhasil', timer: 1800, showConfirmButton: false });
  };
  window.swalError = function (msg) {
    Swal.fire({ icon: 'error', title: 'Gagal', text: msg || 'Terjadi kesalahan.' });
  };

  // ---- Auto-attach: hanya di modul BA / PICA / Assessment -------------------
  const path = window.location.pathname.toLowerCase();
  const moduleRegex = /(beritaacara|^\/pica|create_pica|save_pica|dashboard_pica|detail_check_pica|reprint_pica|priority-note|add_prioritas_note|asasmen|assasmen|asesmen|print_asasmen)/;
  if (!moduleRegex.test(path)) return;

  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.hasAttribute('data-no-swal')) return;

    const method = (form.method || 'get').toLowerCase();
    if (method === 'get') return; // search/filter forms → skip

    // Skip form filter DataTables (biasanya di-handle JS sendiri)
    if (form.closest('.dataTables_filter')) return;

    window.swalLoading('Memproses...');
  }, true);
})();
</script>
