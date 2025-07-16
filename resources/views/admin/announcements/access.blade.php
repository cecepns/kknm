@extends('layouts.dashboard')

@section('title', 'Akses Pengumuman')

@section('content')
<div class="page-header">
    <h1 class="page-title">Akses Pengumuman</h1>
    <button class="btn-primary">Tambah Akses</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengumuman</th>
                <th>Role</th>
                <th>Jenis Akses</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ACC001</td>
                <td>Pendaftaran KKN Periode 2024</td>
                <td>Mahasiswa</td>
                <td>Baca</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ACC002</td>
                <td>Jadwal Pelatihan KKN</td>
                <td>Koordinator KKN</td>
                <td>Baca & Edit</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ACC003</td>
                <td>Pengumuman Hasil Seleksi</td>
                <td>Admin</td>
                <td>Penuh</td>
                <td>Aktif</td>
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