@extends('layouts.dashboard')

@section('title', 'Forum Diskusi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Forum Diskusi</h1>
    <button class="btn-primary">Buat Topik Baru</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Topik</th>
                <th>Kategori</th>
                <th>Pembuat</th>
                <th>Jumlah Balasan</th>
                <th>Tanggal Dibuat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TOPIC001</td>
                <td>Cara mendaftar KKN online</td>
                <td>Pendaftaran KKN</td>
                <td>John Doe</td>
                <td>15</td>
                <td>2024-01-15</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Lihat</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>TOPIC002</td>
                <td>Jadwal pelatihan KKN 2024</td>
                <td>Pelatihan KKN</td>
                <td>Jane Smith</td>
                <td>8</td>
                <td>2024-01-12</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Lihat</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>TOPIC003</td>
                <td>Format laporan KKN yang benar</td>
                <td>Laporan KKN</td>
                <td>Bob Johnson</td>
                <td>23</td>
                <td>2024-01-10</td>
                <td>Nonaktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Lihat</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection 