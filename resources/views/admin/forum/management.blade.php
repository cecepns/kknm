@extends('layouts.dashboard')

@section('title', 'Kelola Forum Diskusi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Forum Diskusi</h1>
    <button class="btn-primary">Tambah Moderator</button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori Forum</th>
                <th>Moderator</th>
                <th>Jumlah Topik</th>
                <th>Jumlah Post</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FORUM001</td>
                <td>Pendaftaran KKN</td>
                <td>John Doe</td>
                <td>45</td>
                <td>156</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>FORUM002</td>
                <td>Pelatihan KKN</td>
                <td>Jane Smith</td>
                <td>32</td>
                <td>89</td>
                <td>Aktif</td>
                <td>
                    <div class="action-links">
                        <a href="#">Edit</a>
                        <a href="#">Hapus</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>FORUM003</td>
                <td>Laporan KKN</td>
                <td>Bob Johnson</td>
                <td>28</td>
                <td>67</td>
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