@extends('layouts.dashboard')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Pengumuman</h1>
    <p class="mb-4">Halaman ini menampilkan daftar semua pengumuman yang telah dibuat.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('form.tambah.kelola.pengumuman') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengumuman
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal Publikasi</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($announcement->published_date)->format('d F Y') }}</td>
                                <td>{{ $announcement->user->nama ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('form.edit.kelola.pengumuman', $announcement->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('hapus.kelola.pengumuman', $announcement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada pengumuman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
