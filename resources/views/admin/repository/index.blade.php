@extends('layouts.dashboard')

@section('title', 'Kelola Repositori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Repositori</h1>
    <button class="btn-primary">Tambah Dokumen</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Dokumen</th>
                <th>Kategori</th>
                <th>Ukuran</th>
                <th>Tanggal Upload</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>DOC001</td>
                <td>Panduan KKN 2024</td>
                <td>Panduan</td>
                <td>2.5 MB</td>
                <td>2024-01-15</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Download</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>DOC002</td>
                <td>Laporan KKN Desa Sukamaju</td>
                <td>Laporan</td>
                <td>1.8 MB</td>
                <td>2024-01-10</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Download</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>DOC003</td>
                <td>Template Proposal KKN</td>
                <td>Template</td>
                <td>500 KB</td>
                <td>2024-01-05</td>
                <td>Nonaktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Download</a>
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection 