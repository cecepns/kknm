@extends('layouts.dashboard')

@section('title', 'Kelola Kategori Forum Diskusi')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Kategori Forum Diskusi</h1>
        <p class="text-gray-600">Halaman ini menampilkan daftar semua kategori forum diskusi yang telah dibuat.</p>
    </div>
    <a href="{{ route('form.tambah.kelola.kategori.forum') }}" class="btn btn-primary">
        ✨ Tambah Kategori Forum Diskusi
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Topik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td class="font-medium">{{ $category->name }}</td>
                    <td>
                        <div class="category-description">
                            {{ $category->description ?? 'Tidak ada deskripsi' }}
                        </div>
                    </td>
                    <td>{{ $category->topic_count }}</td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('form.edit.kelola.kategori.forum', $category->id) }}">Edit</a>
                            <form action="{{ route('hapus.kelola.kategori.forum', $category->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori forum ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500">Belum ada kategori forum.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 