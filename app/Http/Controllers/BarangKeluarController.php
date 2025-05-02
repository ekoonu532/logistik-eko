<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Http\Requests\StoreBarangKeluarRequest;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluars = BarangKeluar::with('barang')->latest()->get();
        return view('barang_keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('barang_keluar.create', compact('barangs'));
    }

    public function store(StoreBarangKeluarRequest $request)
    {
        $validatedData = $request->validated();
        $barang = Barang::findOrFail($validatedData['barang_id']);
        
        DB::beginTransaction();
        
        try {
            $lastBarangKeluar = BarangKeluar::latest()->first();
            $noUrut = $lastBarangKeluar ? intval(substr($lastBarangKeluar->no_barang_keluar, 3)) + 1 : 1;
            $no_barang_keluar = 'BK-' . str_pad($noUrut, 6, '0', STR_PAD_LEFT);
            
            BarangKeluar::create([
                'no_barang_keluar' => $no_barang_keluar,
                'barang_id' => $validatedData['barang_id'],
                'kode_barang' => $barang->kode_barang,
                'quantity' => $validatedData['quantity'],
                'destination' => $validatedData['destination'],
                'tanggal_keluar' => $validatedData['tanggal_keluar'],
            ]);
            
            $barang->stok -= $validatedData['quantity'];
            $barang->save();
            
            DB::commit();
            
            return redirect()->route('barang-keluar.index')
                ->with('success', 'Barang keluar berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}