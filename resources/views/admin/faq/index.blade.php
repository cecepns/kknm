@extends('layouts.dashboard')

@section('title', 'Kelola FAQ')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola FAQ</h1>
    <button class="btn-primary">Tambah FAQ</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pertanyaan</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FAQ001</td>
                <td>Bagaimana cara mendaftar KKN?</td>
                <td>Pendaftaran</td>
                <td>Aktif</td>
                <td>2024-01-15</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>FAQ002</td>
                <td>Berapa lama durasi KKN?</td>
                <td>Umum</td>
                <td>Aktif</td>
                <td>2024-01-10</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>FAQ003</td>
                <td>Apakah ada biaya untuk KKN?</td>
                <td>Biaya</td>
                <td>Nonaktif</td>
                <td>2024-01-05</td>
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