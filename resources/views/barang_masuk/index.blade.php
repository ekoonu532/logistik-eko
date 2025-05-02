@extends('layouts.app')

@section('title', 'Daftar Barang Masuk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 px-4 pt-2">
    <h1 class="h3 mb-0 text-gray-800">Daftar Barang Masuk</h1>
    <a href="{{ route('barang-masuk.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="bi bi-plus-circle fa-sm text-white-50"></i> Tambah Barang Masuk
    </a>
</div>

<div class="row px-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Barang Masuk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Barang Masuk</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Quantity</th>
                                <th>Origin (Asal)</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMasuks as $index => $barangMasuk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $barangMasuk->no_barang_masuk }}</span>
                                    </td>
                                    <td>{{ $barangMasuk->kode_barang }}</td>
                                    <td>{{ $barangMasuk->barang->nama_barang }}</td>
                                    <td><span class="badge bg-success">{{ $barangMasuk->quantity }}</span></td>
                                    <td>{{ $barangMasuk->origin }}</td>
                                    <td>{{ $barangMasuk->tanggal_masuk instanceof \DateTime ? $barangMasuk->tanggal_masuk->format('d/m/Y') : date('d/m/Y', strtotime($barangMasuk->tanggal_masuk)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data barang masuk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            $('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "order": [[0, 'desc']]
            });
        } else {
            console.log('JQuery tidak tersedia, DataTables tidak dapat diinisialisasi');
        }
    });
</script>
@endsection