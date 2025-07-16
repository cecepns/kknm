@extends('layouts.dashboard')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Pengumuman</h1>
    <button class="btn-primary">Tambah Pengumuman</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Dibuat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ANN001</td>
                <td>Pendaftaran KKN Periode 2024</td>
                <td>Pendaftaran</td>
                <td>2024-01-15</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ANN002</td>
                <td>Jadwal Pelatihan KKN</td>
                <td>Pelatihan</td>
                <td>2024-01-10</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ANN003</td>
                <td>Pengumuman Hasil Seleksi</td>
                <td>Hasil</td>
                <td>2024-01-05</td>
                <td>Nonaktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection 