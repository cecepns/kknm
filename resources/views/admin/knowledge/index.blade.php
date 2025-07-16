@extends('layouts.dashboard')

@section('title', 'Klasifikasi Pengetahuan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Klasifikasi Pengetahuan</h1>
    <button class="btn-primary">Tambah Klasifikasi</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Klasifikasi</th>
                <th>Deskripsi</th>
                <th>Jumlah Dokumen</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>KNOW001</td>
                <td>Pendidikan</td>
                <td>Dokumen terkait pendidikan dan pembelajaran</td>
                <td>25</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>KNOW002</td>
                <td>Kesehatan</td>
                <td>Dokumen terkait kesehatan masyarakat</td>
                <td>18</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>KNOW003</td>
                <td>Ekonomi</td>
                <td>Dokumen terkait pengembangan ekonomi</td>
                <td>12</td>
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