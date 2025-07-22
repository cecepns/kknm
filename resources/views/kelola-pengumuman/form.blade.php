@extends('layouts.dashboard')

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($announcement) ? route('edit.kelola.pengumuman', $announcement->id) : route('tambah.kelola.pengumuman') }}" method="POST">
            @csrf
            @if (isset($announcement))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">Judul Pengumuman</label>
                <input type="text" class="form-control @error('title') error @enderror" id="title" name="title" value="{{ old('title', $announcement->title ?? '') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="published_date">Tanggal Publikasi</label>
                <input type="date" class="form-control @error('published_date') error @enderror" id="published_date" name="published_date" value="{{ old('published_date', $announcement->published_date ?? '') }}" required>
                @error('published_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Isi Pengumuman</label>
                <textarea class="form-control @error('content') error @enderror" id="content" name="content" rows="10" required>{{ old('content', $announcement->content ?? '') }}</textarea>
                @error('content')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('daftar.kelola.pengumuman') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
