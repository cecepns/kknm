@extends('layouts.dashboard')

@section('title', isset($forumCategory) ? 'Edit Kategori Forum' : 'Tambah Kategori Forum')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($forumCategory) ? 'Edit Kategori Forum' : 'Tambah Kategori Forum' }}</h1>
</div>

<form action="{{ isset($forumCategory) ? route('edit.kelola.kategori.forum', $forumCategory->id) : route('tambah.kelola.kategori.forum') }}" method="POST">
    @csrf
    @if (isset($forumCategory))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Nama Kategori</label>
        <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" value="{{ old('name', $forumCategory->name ?? '') }}" required>
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mt-6">
        <label for="description">Deskripsi</label>
        <textarea class="form-control @error('description') error @enderror" id="description" name="description" rows="4" placeholder="Tulis deskripsi kategori forum di sini...">{{ old('description', $forumCategory->description ?? '') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-actions">
        <a href="{{ route('daftar.kelola.kategori.forum') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection 