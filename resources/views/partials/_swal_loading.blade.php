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
  const moduleRegex = /(beritaacara|^\/pica|create_pica|save_pica|dashboard_pica|detail_check_pica|reprint_pica|priority-note|add_prioritas_note|asasmen|assasmen|asesmen|print_asasmen|history_asasmen)/;
  const isInModule = moduleRegex.test(path);

  // 1) Submit form (GET filter + POST/PUT/DELETE) → tampil loading
  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.hasAttribute('data-no-swal')) return;
    if (!isInModule) return;

    // Skip live search DataTables (sudah ada filter di sisi client)
    if (form.closest('.dataTables_filter')) return;
    if (form.matches('[role="search"]')) return;

    window.swalLoading('Memproses...');
  }, true);

  // 2) Navigasi (klik <a>) menuju halaman modul yang berat → tampil loading
  //    Hanya untuk URL yang match moduleRegex, link normal (left-click, no modifier, target tidak _blank).
  document.addEventListener('click', function (e) {
    const a = e.target.closest('a');
    if (!a) return;
    if (a.hasAttribute('data-no-swal')) return;
    if (a.target && a.target !== '' && a.target !== '_self') return;
    if (e.button !== 0 || e.ctrlKey || e.shiftKey || e.altKey || e.metaKey) return;

    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    if (a.hasAttribute('download')) return;

    // Resolve relative URL terhadap origin saat ini
    let target;
    try { target = new URL(href, window.location.origin); }
    catch (_) { return; }
    if (target.origin !== window.location.origin) return;

    const targetPath = target.pathname.toLowerCase();
    if (!moduleRegex.test(targetPath)) return;

    // Skip jika sama persis dgn URL saat ini (anchor / no-op navigation)
    if (targetPath === path && target.search === window.location.search) return;

    window.swalLoading('Memuat halaman...');
  }, true);

  // Pastikan overlay tertutup saat user pakai back/forward (bfcache)
  window.addEventListener('pageshow', function () {
    if (typeof Swal !== 'undefined' && Swal.isVisible()) Swal.close();
  });
})();
</script>
