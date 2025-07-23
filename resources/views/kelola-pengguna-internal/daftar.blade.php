@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna Internal')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Pengguna Internal</h1>
        <p class="text-gray-600">Kelola data pengguna internal sistem KMS KKN</p>
    </div>
    <a href="{{ route('form.tambah.pengguna.internal') }}" class="btn btn-primary">
        👤 Tambah Pengguna
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="font-medium">{{ $user->id }}</td>
                <td class="font-medium">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge">{{ $user->role->name ?? 'Tanpa Role' }}</span>
                </td>
                <td>
                    <span class="status-badge status-{{ $user->status == 'aktif' ? 'active' : 'inactive' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td>
                    <div class="action-links">
                        <a href="{{ route('form.edit.pengguna.internal', $user->id) }}">Edit</a>
                        <form action="{{ route('hapus.pengguna.internal', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-gray-500">Tidak ada data pengguna internal untuk ditampilkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
