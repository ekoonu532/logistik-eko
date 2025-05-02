<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required',
            'stok' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'kode_barang.required' => 'Kode barang harus diisi',
            'kode_barang.unique' => 'Kode barang sudah digunakan, silakan gunakan kode yang lain',
            'kode_barang.max' => 'Kode barang maksimal 50 karakter',
        ];
    }
}