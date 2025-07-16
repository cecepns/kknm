@extends('layouts.dashboard')

@section('title', 'Repositori Publik')

@section('content')
<div class="page-header">
    <h1 class="page-title">Repositori Publik</h1>
    <button class="btn-primary">Tambah Dokumen Publik</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Dokumen</th>
                <th>Kategori</th>
                <th>Ukuran</th>
                <th>Download</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>PUB001</td>
                <td>Panduan Umum KKN</td>
                <td>Panduan</td>
                <td>1.2 MB</td>
                <td>156</td>
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
                <td>PUB002</td>
                <td>Laporan KKN 2023</td>
                <td>Laporan</td>
                <td>3.1 MB</td>
                <td>89</td>
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
                <td>PUB003</td>
                <td>Template Laporan KKN</td>
                <td>Template</td>
                <td>800 KB</td>
                <td>234</td>
                <td>Aktif</td>
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