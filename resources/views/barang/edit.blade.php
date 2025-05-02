@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 px-4 pt-2">
    <h1 class="h3 mb-0 text-gray-800">Edit Barang</h1>
    <a href="{{ route('barang.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="bi bi-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row px-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Barang</h6>
            </div>
            <div class="card-body">
                <form id="formEditBarang" action="{{ route('barang.update', $barang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_barang" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" 
                                           id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                                    @error('kode_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Kode unik untuk identifikasi barang</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                           id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                                    @error('nama_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Jumlah stok saat ini</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-warning mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Perhatian!</h5>
                                <p class="mb-0">Mengubah stok barang secara manual dapat mempengaruhi proses pencatatan keluar/masuk barang. Pastikan perubahan stok dilakukan dengan benar.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save"></i> Update Data
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
        const kodeBarangInput = document.getElementById('kode_barang');
        const form = document.getElementById('formEditBarang');
        const submitButton = document.getElementById('btnSubmit');
        const loadingSpinner = document.getElementById('loadingSpinner');
        let formSubmitted = false;
        
        kodeBarangInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
        
        form.addEventListener('submit', function(event) {
            if (formSubmitted) {
                event.preventDefault();
                return false;
            }
            
            let isValid = true;
            
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            const stokInput = document.getElementById('stok');
            if (parseInt(stokInput.value) < 0) {
                stokInput.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
                
                const firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
            } else {
                formSubmitted = true;
                
                loadingSpinner.classList.remove('d-none');
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.querySelector('i').classList.add('d-none');
                
                return true;
            }
        });
    });
</script>
@endsection