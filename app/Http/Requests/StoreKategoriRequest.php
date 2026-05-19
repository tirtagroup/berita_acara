<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $kategoriId = $this->route('id');

        return [
            'kode'       => ['required', 'string', 'max:50', 'regex:/^[A-Z0-9_]+$/',
                             Rule::unique('ms_ba_kategori', 'kode')->ignore($kategoriId)],
            'nama'       => ['required', 'string', 'max:100'],
            'parent_id'  => ['nullable', 'integer', 'exists:ms_ba_kategori,id', "different:{$kategoriId}"],
            'active'     => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.regex'      => 'Kode hanya boleh huruf besar, angka, dan underscore (contoh: PELANGGARAN_SOP).',
            'kode.unique'     => 'Kode kategori ini sudah dipakai.',
            'parent_id.different' => 'Kategori tidak boleh jadi parent dari dirinya sendiri.',
        ];
    }
}
