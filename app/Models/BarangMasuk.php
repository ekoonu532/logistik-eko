<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_barang_masuk',
        'barang_id',
        'kode_barang',
        'quantity',
        'origin',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
    ];


    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}