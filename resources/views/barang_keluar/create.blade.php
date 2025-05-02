@extends('layouts.app')

@section('title', 'Pencatatan Barang Keluar')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 px-4 pt-2">
    <h1 class="h3 mb-0 text-gray-800">Pencatatan Barang Keluar</h1>
    <a href="{{ route('barang-keluar.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="bi bi-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row px-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Pencatatan Barang Keluar</h6>
            </div>
            <div class="card-body">
                <form id="formBarangKeluar" action="{{ route('barang-keluar.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
                                <select class="form-select @error('barang_id') is-invalid @enderror" 
                                        id="barang_id" name="barang_id" required>
                                    <option value="" selected disabled>Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-kode="{{ $barang->kode_barang }}" data-stok="{{ $barang->stok }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
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
                                <small class="text-muted" id="stok-tersedia">Stok tersedia: -</small>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="destination" class="form-label">Destination (Tujuan) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror" 
                                       id="destination" name="destination" value="{{ old('destination') }}" required>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_keluar" class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror" 
                                       id="tanggal_keluar" name="tanggal_keluar" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-3 mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Perhatian!</h5>
                                <p class="mb-0">Pencatatan barang keluar akan otomatis mengurangi stok barang yang dipilih. Pastikan quantity yang dimasukkan tidak melebihi stok yang tersedia.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary me-2">
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
        const stokTersedia = document.getElementById('stok-tersedia');
        const quantityInput = document.getElementById('quantity');
        const submitBtn = document.getElementById('btnSubmit');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const form = document.getElementById('formBarangKeluar');
        let formSubmitted = false;
        
        barangSelect.addEventListener('change', function() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            
            stokTersedia.textContent = `Stok tersedia: ${stok}`;
            quantityInput.setAttribute('max', stok);
            
            quantityInput.focus();
            
            validateQuantity();
        });
        
        quantityInput.addEventListener('input', validateQuantity);
        
        function validateQuantity() {
            if (barangSelect.value) {
                const selectedOption = barangSelect.options[barangSelect.selectedIndex];
                const stok = parseInt(selectedOption.getAttribute('data-stok'));
                const quantity = parseInt(quantityInput.value) || 0;
                
                if (quantity > stok) {
                    quantityInput.classList.add('is-invalid');
                    stokTersedia.innerHTML = `<span class="text-danger">Stok tidak mencukupi! Tersedia: ${stok}</span>`;
                    submitBtn.disabled = true;
                } else if (quantity <= 0) {
                    quantityInput.classList.add('is-invalid');
                    stokTersedia.textContent = `Stok tersedia: ${stok}`;
                    submitBtn.disabled = true;
                } else {
                    quantityInput.classList.remove('is-invalid');
                    stokTersedia.textContent = `Stok tersedia: ${stok}`;
                    submitBtn.disabled = false;
                }
            }
        }
        
        if (barangSelect.value) {
            barangSelect.dispatchEvent(new Event('change'));
        }
        
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