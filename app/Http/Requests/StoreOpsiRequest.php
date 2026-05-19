<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpsiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Validasi untuk add/update opsi DI KONTEKS satu kategori (per-kategori page).
     * Kode unik per kategori (di pivot mapping).
     */
    public function rules(): array
    {
        return [
            'deskripsi'  => ['required', 'string', 'max:500'],
            'kode'       => ['required', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'active'     => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode opsi wajib diisi.',
        ];
    }
}
