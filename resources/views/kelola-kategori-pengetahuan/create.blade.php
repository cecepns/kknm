@extends('layouts.dashboard')

@section('title', 'Tambah Kategori Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Kategori Pengetahuan</h1>
    </div>
    <div>
        <a href="{{ route('kelola.kategori.pengetahuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- ANCHOR: Flash Messages -->
@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<!-- ANCHOR: Form -->
<div class="form-container">
    <form action="{{ route('kelola.kategori.pengetahuan.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" 
                id="name" 
                name="name" 
                class="form-control @error('name') error @enderror" 
                placeholder="Masukkan nama kategori"
                value="{{ old('name') }}"
                required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('kelola.kategori.pengetahuan.index') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

@endsection 