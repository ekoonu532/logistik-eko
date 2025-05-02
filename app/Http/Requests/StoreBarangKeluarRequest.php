<?php

namespace App\Http\Requests;

use App\Models\Barang;
use Illuminate\Foundation\Http\FormRequest;

class StoreBarangKeluarRequest extends FormRequest
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
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|numeric|min:1',
            'destination' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date',
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
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang yang dipilih tidak valid',
            'quantity.required' => 'Jumlah barang harus diisi',
            'quantity.numeric' => 'Jumlah barang harus berupa angka',
            'quantity.min' => 'Jumlah barang minimal 1',
            'destination.required' => 'Tujuan harus diisi',
            'destination.max' => 'Tujuan maksimal 255 karakter',
            'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
            'tanggal_keluar.date' => 'Format tanggal keluar tidak valid',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $barang = Barang::find($this->barang_id);
            if ($barang && $barang->stok < $this->quantity) {
                $validator->errors()->add('quantity', 'Stok barang tidak mencukupi! Stok tersedia: ' . $barang->stok);
            }
        });
    }
}