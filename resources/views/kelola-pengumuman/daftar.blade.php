@extends('layouts.dashboard')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pengumuman</h1>
        <p class="text-gray-600">Halaman ini menampilkan daftar semua pengumuman yang telah dibuat.</p>
    </div>
    <a href="{{ route('form.tambah.kelola.pengumuman') }}" class="btn btn-primary">
            Tambah Pengumuman
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<div class="table-container">
    <table class="table">
                            <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Publikasi</th>
                            <th>Dibuat Oleh</th>
                            <th>Preview Konten</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
        <tbody>
                                    @forelse ($announcements as $announcement)
                            <tr>
                                <td class="font-medium">{{ $announcement->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($announcement->published_date)->format('d F Y') }}</td>
                                <td>{{ $announcement->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="announcement-preview">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($announcement->content), 100, '...') !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-links">
                                        <a href="{{ route('form.edit.kelola.pengumuman', $announcement->id) }}">Edit</a>
                                        <form action="{{ route('hapus.kelola.pengumuman', $announcement->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-link" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500">Belum ada pengumuman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
