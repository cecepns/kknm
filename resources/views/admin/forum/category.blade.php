@extends('layouts.dashboard')

@section('title', 'Kelola Kategori Forum')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Kategori Forum</h1>
    <button class="btn-primary">Tambah Kategori</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Topik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CAT001</td>
                <td>Pendaftaran KKN</td>
                <td>Diskusi terkait pendaftaran KKN</td>
                <td>45</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>CAT002</td>
                <td>Pelatihan KKN</td>
                <td>Diskusi terkait pelatihan KKN</td>
                <td>32</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>CAT003</td>
                <td>Laporan KKN</td>
                <td>Diskusi terkait laporan KKN</td>
                <td>28</td>
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