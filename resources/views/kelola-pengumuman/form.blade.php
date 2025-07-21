@extends('layouts.dashboard')

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">{{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($announcement) ? route('edit.kelola.pengumuman', $announcement->id) : route('tambah.kelola.pengumuman') }}" method="POST">
                @csrf
                @if (isset($announcement))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Judul Pengumuman</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $announcement->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="published_date">Tanggal Publikasi</label>
                    <input type="date" class="form-control @error('published_date') is-invalid @enderror" id="published_date" name="published_date" value="{{ old('published_date', $announcement->published_date ?? '') }}" required>
                    @error('published_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Isi Pengumuman</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $announcement->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('daftar.kelola.pengumuman') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
