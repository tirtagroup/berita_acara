<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Seed master pertanyaan PICA berdasarkan standar investigasi (5W+2H, 4M+1E, 5Why, ...).
 *
 * Total ~82 pertanyaan. Yang esensial = wajib_universal (12 item),
 * sisanya = bantuan (PIC pilih saat setup PICA).
 *
 * Semua tipe = 'pertanyaan' (text answer). Admin bisa ubah ke 'pernyataan'
 * via UI bila mau format Setuju/Tidak Setuju.
 */
return new class extends Migration
{
    public function up()
    {
        $now = now();

        // Definisi: [kode, pertanyaan, scope, urutan]
        // Scope 'W' = wajib_universal, 'B' = bantuan
        $items = [
            // ============ A. IDENTIFIKASI MASALAH (5W + 2H) ============
            // What
            ['WHAT_KEJADIAN',         'Apa kejadian / masalah yang terjadi?',                                 'W', 10],
            ['WHAT_SOP_ACUAN',        'Apa standar atau SOP yang menjadi acuan?',                            'B', 11],
            ['WHAT_SIMPANGAN',        'Apa yang menyimpang dari standar tersebut?',                          'B', 12],
            ['WHAT_KATEGORI',         'Apa kategori kejadiannya (laka, pelanggaran SOP, kerusakan, dll)?',   'B', 13],
            // When
            ['WHEN_TANGGAL_JAM',      'Kapan kejadian terjadi (tanggal & jam)?',                             'W', 20],
            ['WHEN_DIKETAHUI',        'Kapan kejadian pertama kali diketahui?',                              'B', 21],
            ['WHEN_DILAPORKAN',       'Kapan kejadian dilaporkan?',                                          'B', 22],
            ['WHEN_BERULANG',         'Apakah ini kejadian pertama atau berulang? Bila berulang, kapan terakhir?', 'B', 23],
            // Where
            ['WHERE_LOKASI',          'Di mana lokasi tepatnya?',                                            'W', 30],
            ['WHERE_PROSES',          'Pada proses / tahap apa kejadian terjadi?',                           'B', 31],
            ['WHERE_RAWAN',           'Apakah lokasi tersebut rawan kejadian serupa?',                       'B', 32],
            // Who
            ['WHO_PELAKU_KORBAN',     'Siapa yang terlibat langsung (pelaku / korban)?',                     'W', 40],
            ['WHO_SAKSI',             'Siapa saksi yang melihat?',                                           'B', 41],
            ['WHO_PELAPOR',           'Siapa yang pertama melaporkan?',                                      'B', 42],
            ['WHO_PIC_AREA',          'Siapa atasan / PIC area saat kejadian?',                              'B', 43],
            ['WHO_PIHAK_KETIGA',      'Apakah pihak ketiga terlibat?',                                       'B', 44],
            // Why (awal)
            ['WHY_KATEGORI_MASALAH',  'Mengapa ini dikategorikan sebagai masalah?',                          'W', 50],
            ['WHY_DAMPAK',            'Apa dampak yang ditimbulkan (operasional, finansial, reputasi, keselamatan)?', 'B', 51],
            // How
            ['HOW_KRONOLOGI',         'Bagaimana kronologi lengkapnya (urutan kejadian)?',                   'W', 60],
            ['HOW_TERDETEKSI',        'Bagaimana kejadian akhirnya diketahui / terdeteksi?',                 'B', 61],
            ['HOW_RESPON_AWAL',       'Bagaimana respons awal di lapangan?',                                 'B', 62],
            // How much
            ['HOWMUCH_RUGI_MATERIIL', 'Berapa kerugian materiil (rupiah)?',                                  'B', 70],
            ['HOWMUCH_KORBAN',        'Berapa korban / cedera (jika ada)?',                                  'B', 71],
            ['HOWMUCH_DAMPAK_LUAS',   'Seberapa luas dampak (1 unit, 1 divisi, lintas divisi)?',             'B', 72],
            ['HOWMUCH_GANGGUAN',      'Berapa lama gangguan operasional?',                                   'B', 73],

            // ============ B. ANALISA PENYEBAB (4M + 1E) ============
            // Man
            ['MAN_KOMPETENSI',        'Apakah petugas memiliki kompetensi yang dipersyaratkan?',             'B', 110],
            ['MAN_TRAINING',          'Apakah sudah mengikuti training terkait?',                            'B', 111],
            ['MAN_FISIK_MENTAL',      'Bagaimana kondisi fisik & mental saat kejadian (fatigue, sakit, emosi)?', 'B', 112],
            ['MAN_DISIPLIN',          'Apakah ada pelanggaran disiplin atau kelalaian?',                     'B', 113],
            ['MAN_JAM_KERJA',         'Apakah jam kerja berlebih atau di luar shift normal?',                'B', 114],
            ['MAN_PENGALAMAN',        'Apakah pengalaman kerja memadai?',                                    'B', 115],
            // Machine
            ['MACHINE_LAYAK',         'Apakah kendaraan / alat dalam kondisi layak operasi?',                'B', 120],
            ['MACHINE_SERVICE',       'Kapan terakhir di-service atau inspeksi?',                            'B', 121],
            ['MACHINE_KERUSAKAN',     'Apakah ada laporan kerusakan sebelumnya yang belum ditangani?',       'B', 122],
            ['MACHINE_SPESIFIKASI',   'Apakah alat sesuai spesifikasi untuk pekerjaan tersebut?',            'B', 123],
            ['MACHINE_APD',           'Apakah alat pelindung diri (APD) tersedia & dipakai?',                'B', 124],
            // Material
            ['MATERIAL_STANDAR',      'Apakah material / muatan sesuai standar?',                            'B', 130],
            ['MATERIAL_PACKING',      'Apakah cara packing / loading benar?',                                'B', 131],
            ['MATERIAL_CACAT',        'Apakah ada cacat material dari supplier?',                            'B', 132],
            ['MATERIAL_PENYIMPANAN',  'Apakah penyimpanan sudah sesuai?',                                    'B', 133],
            // Method
            ['METHOD_SOP_TERSEDIA',   'Apakah SOP untuk aktivitas ini tersedia?',                            'B', 140],
            ['METHOD_SOP_SOSIALISASI','Apakah SOP sudah disosialisasikan ke petugas?',                       'B', 141],
            ['METHOD_SOP_PAHAM',      'Apakah petugas memahami isi SOP?',                                    'B', 142],
            ['METHOD_SOP_RELEVAN',    'Apakah SOP masih relevan / up-to-date?',                              'B', 143],
            ['METHOD_SOP_DIIKUTI',    'Apakah SOP benar-benar diikuti?',                                     'B', 144],
            ['METHOD_SHORTCUT',       'Apakah ada short-cut yang menjadi kebiasaan?',                        'B', 145],
            // Environment
            ['ENV_CUACA',             'Bagaimana kondisi cuaca saat kejadian?',                              'B', 150],
            ['ENV_JALAN',             'Bagaimana kondisi jalan / lokasi (rusak, licin, gelap)?',             'B', 151],
            ['ENV_PENCAHAYAAN',       'Apakah pencahayaan & ventilasi memadai?',                             'B', 152],
            ['ENV_AREA_RAPI',         'Apakah area kerja tertata rapi?',                                     'B', 153],
            ['ENV_TEKANAN',           'Apakah ada tekanan eksternal (target, deadline mendadak)?',           'B', 154],

            // ============ C. 5 WHY ROOT CAUSE ANALYSIS ============
            ['WHY_1',                 'Why 1: Mengapa kejadian ini terjadi?',                                'W', 210],
            ['WHY_2',                 'Why 2: Mengapa hal sebelumnya bisa terjadi?',                         'W', 211],
            ['WHY_3',                 'Why 3: Mengapa hal sebelumnya bisa terjadi?',                         'W', 212],
            ['WHY_4',                 'Why 4: Mengapa hal sebelumnya bisa terjadi?',                         'B', 213],
            ['WHY_5_ROOT_CAUSE',      'Why 5: Apa akar masalah sebenarnya?',                                 'W', 214],

            // ============ D. TINDAKAN KOREKTIF ============
            ['KOREKTIF_SEGERA',       'Apa tindakan segera untuk menghentikan dampak?',                      'W', 310],
            ['KOREKTIF_PEMULIHAN',    'Apa tindakan untuk memulihkan kondisi (perbaikan, penggantian)?',     'B', 311],
            ['KOREKTIF_PIC',          'Siapa PIC pelaksanaan setiap tindakan?',                              'B', 312],
            ['KOREKTIF_DEADLINE',     'Kapan target selesai (deadline)?',                                    'B', 313],
            ['KOREKTIF_KONFIRMASI',   'Bagaimana cara konfirmasi tindakan sudah dilaksanakan?',              'B', 314],
            ['KOREKTIF_EKSTERNAL',    'Apakah perlu pelaporan ke pihak eksternal (asuransi, kepolisian, regulator)?', 'B', 315],

            // ============ E. TINDAKAN PENCEGAHAN ============
            ['PREVENTIF_SOLUSI',      'Apa solusi jangka panjang untuk root cause yang ditemukan?',          'W', 410],
            ['PREVENTIF_SOP',         'Apakah perlu revisi atau pembuatan SOP baru?',                        'B', 411],
            ['PREVENTIF_TRAINING',    'Apakah perlu training ulang / refresher?',                            'B', 412],
            ['PREVENTIF_ALAT',        'Apakah perlu pengadaan alat / sistem baru?',                          'B', 413],
            ['PREVENTIF_STRUKTUR',    'Apakah perlu perubahan struktur kerja / shift?',                      'B', 414],
            ['PREVENTIF_SOSIALISASI', 'Apakah perlu sosialisasi ke unit lain agar tidak terjadi di tempat berbeda?', 'B', 415],
            ['PREVENTIF_PIC',         'Siapa PIC pencegahan?',                                               'B', 416],
            ['PREVENTIF_DEADLINE',    'Kapan target implementasi penuh?',                                    'B', 417],

            // ============ F. VERIFIKASI & MONITORING ============
            ['VERIF_UKUR',            'Bagaimana cara mengukur efektivitas tindakan?',                       'B', 510],
            ['VERIF_KPI',             'Apa indikator keberhasilan (KPI)?',                                   'B', 511],
            ['VERIF_REVIEW',          'Kapan dilakukan review (1 minggu, 1 bulan, 3 bulan)?',                'B', 512],
            ['VERIF_AUDIT',           'Siapa yang melakukan audit / verifikasi?',                            'B', 513],
            ['VERIF_BERULANG',        'Apakah masalah masih berulang setelah tindakan diterapkan?',          'B', 514],
            ['VERIF_EFEK_SAMPING',    'Apakah ada efek samping dari tindakan yang diambil?',                 'B', 515],

            // ============ G. CLOSURE & LESSON LEARNED ============
            ['CLOSURE_TINDAKAN_DONE', 'Apakah seluruh tindakan korektif & preventif sudah dilaksanakan?',    'B', 610],
            ['CLOSURE_EFEKTIF',       'Apakah hasilnya efektif?',                                            'B', 611],
            ['CLOSURE_PELAJARAN',     'Pelajaran apa yang bisa diambil organisasi?',                         'B', 612],
            ['CLOSURE_SEBARKAN',      'Apakah perlu disebarluaskan ke unit / cabang lain?',                  'B', 613],
            ['CLOSURE_TGL_APPROVED',  'Tanggal closure dan disetujui siapa?',                                'B', 614],
            ['CLOSURE_DOKUMENTASI',   'Dokumentasi final tersimpan di mana?',                                'B', 615],
        ];

        $rows = [];
        foreach ($items as [$kode, $pertanyaan, $scopeFlag, $urutan]) {
            $rows[] = [
                'kode'       => $kode,
                'pertanyaan' => $pertanyaan,
                'tipe'       => 'pertanyaan',
                'scope'      => $scopeFlag === 'W' ? 'wajib_universal' : 'bantuan',
                'urutan'     => $urutan,
                'active'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert per batch (avoid query size limit)
        foreach (array_chunk($rows, 50) as $batch) {
            DB::table('ms_pica_pertanyaan_master')->insert($batch);
        }
    }

    public function down()
    {
        $kodes = [
            'WHAT_KEJADIAN','WHAT_SOP_ACUAN','WHAT_SIMPANGAN','WHAT_KATEGORI',
            'WHEN_TANGGAL_JAM','WHEN_DIKETAHUI','WHEN_DILAPORKAN','WHEN_BERULANG',
            'WHERE_LOKASI','WHERE_PROSES','WHERE_RAWAN',
            'WHO_PELAKU_KORBAN','WHO_SAKSI','WHO_PELAPOR','WHO_PIC_AREA','WHO_PIHAK_KETIGA',
            'WHY_KATEGORI_MASALAH','WHY_DAMPAK',
            'HOW_KRONOLOGI','HOW_TERDETEKSI','HOW_RESPON_AWAL',
            'HOWMUCH_RUGI_MATERIIL','HOWMUCH_KORBAN','HOWMUCH_DAMPAK_LUAS','HOWMUCH_GANGGUAN',
            'MAN_KOMPETENSI','MAN_TRAINING','MAN_FISIK_MENTAL','MAN_DISIPLIN','MAN_JAM_KERJA','MAN_PENGALAMAN',
            'MACHINE_LAYAK','MACHINE_SERVICE','MACHINE_KERUSAKAN','MACHINE_SPESIFIKASI','MACHINE_APD',
            'MATERIAL_STANDAR','MATERIAL_PACKING','MATERIAL_CACAT','MATERIAL_PENYIMPANAN',
            'METHOD_SOP_TERSEDIA','METHOD_SOP_SOSIALISASI','METHOD_SOP_PAHAM','METHOD_SOP_RELEVAN','METHOD_SOP_DIIKUTI','METHOD_SHORTCUT',
            'ENV_CUACA','ENV_JALAN','ENV_PENCAHAYAAN','ENV_AREA_RAPI','ENV_TEKANAN',
            'WHY_1','WHY_2','WHY_3','WHY_4','WHY_5_ROOT_CAUSE',
            'KOREKTIF_SEGERA','KOREKTIF_PEMULIHAN','KOREKTIF_PIC','KOREKTIF_DEADLINE','KOREKTIF_KONFIRMASI','KOREKTIF_EKSTERNAL',
            'PREVENTIF_SOLUSI','PREVENTIF_SOP','PREVENTIF_TRAINING','PREVENTIF_ALAT','PREVENTIF_STRUKTUR','PREVENTIF_SOSIALISASI','PREVENTIF_PIC','PREVENTIF_DEADLINE',
            'VERIF_UKUR','VERIF_KPI','VERIF_REVIEW','VERIF_AUDIT','VERIF_BERULANG','VERIF_EFEK_SAMPING',
            'CLOSURE_TINDAKAN_DONE','CLOSURE_EFEKTIF','CLOSURE_PELAJARAN','CLOSURE_SEBARKAN','CLOSURE_TGL_APPROVED','CLOSURE_DOKUMENTASI',
        ];
        DB::table('ms_pica_pertanyaan_master')->whereIn('kode', $kodes)->delete();
    }
};
