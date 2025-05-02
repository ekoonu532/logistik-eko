@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-3 px-4 mt-2">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="row g-3 mb-3 p-4">
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title text-primary fw-bold fs-6 mb-2">TOTAL BARANG</h5>
                        <h2 class="fw-bold mb-2">{{ \App\Models\Barang::count() }}</h2>
                    </div>
                    <div class="col-4 text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-box text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('barang.index') }}" class="text-decoration-none text-primary d-flex align-items-center mt-1">
                    Lihat Detail
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title text-success fw-bold fs-6 mb-2">BARANG MASUK</h5>
                        <h2 class="fw-bold mb-2">{{ \App\Models\BarangMasuk::count() }}</h2>
                    </div>
                    <div class="col-4 text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-box-arrow-in-down text-success fs-4"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('barang-masuk.index') }}" class="text-decoration-none text-success d-flex align-items-center mt-1">
                    Lihat Detail
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title text-danger fw-bold fs-6 mb-2">BARANG KELUAR</h5>
                        <h2 class="fw-bold mb-2">{{ \App\Models\BarangKeluar::count() }}</h2>
                    </div>
                    <div class="col-4 text-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-box-arrow-right text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
                <a href="{{ route('barang-keluar.index') }}" class="text-decoration-none text-danger d-flex align-items-center mt-1">
                    Lihat Detail
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3 px-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">Aktivitas Barang Bulanan</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-area" style="height: 300px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">Distribusi Stok Barang</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-pie mb-3" style="height: 240px;">
                    <canvas id="stockDistribution"></canvas>
                </div>
                <div class="d-flex justify-content-center flex-wrap small gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-circle-fill text-primary me-1"></i> 
                        <span>Stok > 100</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-circle-fill text-success me-1"></i> 
                        <span>Stok 50-100</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-circle-fill text-warning me-1"></i> 
                        <span>Stok 10-49</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-circle-fill text-danger me-1"></i> 
                        <span>Stok < 10</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 px-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">Barang Masuk Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3">No. Masuk</th>
                                <th>Kode Barang</th>
                                <th>Quantity</th>
                                <th class="px-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\BarangMasuk::with('barang')->latest()->limit(5)->get() as $barangMasuk)
                            <tr>
                                <td class="px-3">{{ $barangMasuk->no_barang_masuk }}</td>
                                <td>{{ $barangMasuk->kode_barang }}</td>
                                <td>{{ $barangMasuk->quantity }}</td>
                                <td class="px-3">{{ $barangMasuk->tanggal_masuk instanceof \DateTime ? $barangMasuk->tanggal_masuk->format('d/m/Y') : date('d/m/Y', strtotime($barangMasuk->tanggal_masuk)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="m-0 fw-bold text-primary">Barang Keluar Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3">No. Keluar</th>
                                <th>Kode Barang</th>
                                <th>Quantity</th>
                                <th class="px-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\BarangKeluar::with('barang')->latest()->limit(5)->get() as $barangKeluar)
                            <tr>
                                <td class="px-3">{{ $barangKeluar->no_barang_keluar }}</td>
                                <td>{{ $barangKeluar->kode_barang }}</td>
                                <td>{{ $barangKeluar->quantity }}</td>
                                <td class="px-3">{{ $barangKeluar->tanggal_keluar instanceof \DateTime ? $barangKeluar->tanggal_keluar->format('d/m/Y') : date('d/m/Y', strtotime($barangKeluar->tanggal_keluar)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxActivity = document.getElementById('activityChart').getContext('2d');
        var activityChart = new Chart(ctxActivity, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Barang Masuk',
                    data: [
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 1)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 2)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 3)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 4)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 5)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 6)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 7)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 8)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 9)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 10)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 11)->count() }},
                        {{ \App\Models\BarangMasuk::whereYear('created_at', date('Y'))->whereMonth('created_at', 12)->count() }}
                    ],
                    borderColor: '#36b9cc',
                    backgroundColor: 'rgba(54, 185, 204, 0.1)',
                    pointBackgroundColor: '#36b9cc',
                    pointBorderColor: '#36b9cc',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Barang Keluar',
                    data: [
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 1)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 2)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 3)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 4)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 5)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 6)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 7)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 8)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 9)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 10)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 11)->count() }},
                        {{ \App\Models\BarangKeluar::whereYear('created_at', date('Y'))->whereMonth('created_at', 12)->count() }}
                    ],
                    borderColor: '#e74a3b',
                    backgroundColor: 'rgba(231, 74, 59, 0.1)',
                    pointBackgroundColor: '#e74a3b',
                    pointBorderColor: '#e74a3b',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        var ctxStock = document.getElementById('stockDistribution').getContext('2d');
        var stockChart = new Chart(ctxStock, {
            type: 'doughnut',
            data: {
                labels: ['Stok > 100', 'Stok 50-100', 'Stok 10-49', 'Stok < 10'],
                datasets: [{
                    data: [
                        {{ \App\Models\Barang::where('stok', '>', 100)->count() }},
                        {{ \App\Models\Barang::whereBetween('stok', [50, 100])->count() }},
                        {{ \App\Models\Barang::whereBetween('stok', [10, 49])->count() }},
                        {{ \App\Models\Barang::where('stok', '<', 10)->count() }}
                    ],
                    backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#f4b619', '#d52a1a'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>
@endsection