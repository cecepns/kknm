@extends('layouts.dashboard')

@section('title', 'Edit Kategori Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Kategori Pengetahuan</h1>
    </div>
</div>

<!-- ANCHOR: Flash Messages -->
@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('kelola.kategori.pengetahuan.update', $knowledgeCategory) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="name" class="form-label">Nama Kategori</label>
        <input type="text" 
            id="name" 
            name="name" 
            class="form-control @error('name') error @enderror" 
            placeholder="Masukkan nama kategori"
            value="{{ old('name', $knowledgeCategory->name) }}"
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
            <i class="fas fa-save"></i> Update
        </button>
    </div>
</form>
@endsection 