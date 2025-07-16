@extends('layouts.dashboard')

@section('title', 'Kelola Role')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Role</h1>
    <button class="btn-primary">Tambah Role</button>
</div>

<div class="alert-success">
    Role baru berhasil ditambahkan!
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Role</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ROLE001</td>
                <td>Admin</td>
                <td>Role dengan akses penuh ke semua fitur.</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ROLE002</td>
                <td>Kepala PPM</td>
                <td>Role untuk kepala Pusat Pengabdian Masyarakat.</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ROLE003</td>
                <td>Koordinator KKN</td>
                <td>Role untuk koordinator kegiatan KKN.</td>
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