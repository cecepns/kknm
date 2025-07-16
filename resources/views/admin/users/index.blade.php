@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna Internal')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Pengguna Internal</h1>
    <button class="btn-primary">Tambah Pengguna</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>USR001</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>Admin</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>USR002</td>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>Kepala PPM</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>USR003</td>
                <td>Bob Johnson</td>
                <td>bob@example.com</td>
                <td>Koordinator KKN</td>
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