<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangMasukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric|min:1',
            'origin' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'barang_id.required' => 'Silahkan pilih barang terlebih dahulu',
            'barang_id.exists' => 'Barang yang dipilih tidak valid',
            'quantity.required' => 'Jumlah barang wajib diisi',
            'quantity.numeric' => 'Jumlah barang harus berupa angka',
            'quantity.min' => 'Jumlah barang minimal 1',
            'origin.required' => 'Asal barang wajib diisi',
            'origin.string' => 'Asal barang harus berupa teks',
            'origin.max' => 'Asal barang maksimal 255 karakter',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid',
        ];
    }
}