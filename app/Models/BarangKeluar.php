<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_barang_keluar',
        'barang_id',
        'kode_barang',
        'quantity',
        'destination',
        'tanggal_keluar',
    ];

    protected $casts = [
        'tanggal_keluar' => 'datetime',
    ];


    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}