@extends('layouts.dashboard')

@section('title', 'Akses FAQ')

@section('content')
<div class="page-header">
    <h1 class="page-title">Akses FAQ</h1>
    <button class="btn-primary">Tambah Akses</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>FAQ</th>
                <th>Role</th>
                <th>Jenis Akses</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FAQACC001</td>
                <td>Bagaimana cara mendaftar KKN?</td>
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
                <td>FAQACC002</td>
                <td>Berapa lama durasi KKN?</td>
                <td>Semua Role</td>
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
                <td>FAQACC003</td>
                <td>Apakah ada biaya untuk KKN?</td>
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