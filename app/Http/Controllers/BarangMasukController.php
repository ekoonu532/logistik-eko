<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Http\Requests\StoreBarangMasukRequest;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->latest()->get();
        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(StoreBarangMasukRequest $request)
    {
        $barang = Barang::findOrFail($request->barang_id);
        
        DB::beginTransaction();
        
        try {
            $lastBarangMasuk = BarangMasuk::latest()->first();
            $noUrut = $lastBarangMasuk ? intval(substr($lastBarangMasuk->no_barang_masuk, 3)) + 1 : 1;
            $no_barang_masuk = 'BM-' . str_pad($noUrut, 6, '0', STR_PAD_LEFT);
            
            BarangMasuk::create([
                'no_barang_masuk' => $no_barang_masuk,
                'barang_id' => $request->barang_id,
                'kode_barang' => $barang->kode_barang,
                'quantity' => $request->quantity,
                'origin' => $request->origin,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);
            
            $barang->stok += $request->quantity;
            $barang->save();
            
            DB::commit();
            
            return redirect()->route('barang-masuk.index')
                ->with('success', 'Barang masuk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}