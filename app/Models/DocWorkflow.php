<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * In-app help/tutorial documentation.
 * Tabel: ms_doc_workflow
 */
class DocWorkflow extends Model
{
    protected $table = 'ms_doc_workflow';

    protected $fillable = [
        'kode',
        'modul',
        'kategori',
        'judul',
        'ringkasan',
        'konten',
        'target_role',
        'urutan',
        'icon',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'urutan' => 'integer',
    ];

    public const MODULS = ['BA', 'PICA', 'MASTER', 'UMUM'];
    public const KATEGORIS = ['tutorial', 'faq', 'workflow', 'troubleshooting'];
    public const TARGET_ROLES = ['all', 'admin', 'creator', 'pic', 'dewan', 'pelaku'];
}
