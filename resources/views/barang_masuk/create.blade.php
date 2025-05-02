@extends('layouts.app')

@section('title', 'Pencatatan Barang Masuk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 px-4 pt-2">
    <h1 class="h3 mb-0 text-gray-800">Pencatatan Barang Masuk</h1>
    <a href="{{ route('barang-masuk.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="bi bi-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row px-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Pencatatan Barang Masuk</h6>
            </div>
            <div class="card-body">
                <form id="formBarangMasuk" action="{{ route('barang-masuk.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
                                <select class="form-select @error('barang_id') is-invalid @enderror" 
                                        id="barang_id" name="barang_id" required>
                                    <option value="" selected disabled>Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-kode="{{ $barang->kode_barang }}" 
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="origin" class="form-label">Origin (Asal Barang) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('origin') is-invalid @enderror" 
                                       id="origin" name="origin" value="{{ old('origin') }}" required>
                                @error('origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                                       id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3 mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-info-circle-fill me-2"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Informasi Penting!</h5>
                                <p class="mb-0">Pencatatan barang masuk akan otomatis menambahkan stok barang yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save"></i> Simpan Data
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('barang_id');
        const quantityInput = document.getElementById('quantity');
        const submitBtn = document.getElementById('btnSubmit');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const form = document.getElementById('formBarangMasuk');
        let formSubmitted = false;
        
        barangSelect.addEventListener('change', function() {
            quantityInput.focus();
        });
        
        form.addEventListener('submit', function(event) {
            if (formSubmitted) {
                event.preventDefault();
                return false;
            }
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value) {
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                const firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
            } else {
                formSubmitted = true;
                
                loadingSpinner.classList.remove('d-none');
                submitBtn.setAttribute('disabled', 'disabled');
                submitBtn.querySelector('i').classList.add('d-none');
                
                return true;
            }
        });
    });
</script>
@endsection