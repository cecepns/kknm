@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna Internal')

@section('content')

    <header>
        <h1>Kelola Pengguna Internal</h1>
        <a href="{{ route('form.tambah.pengguna.internal') }}">+ Tambah Pengguna</a>
    </header>

    <hr>

    @if(session('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <table>
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
                <td>{{ $user->id }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->nama ?? 'Tanpa Role' }}</td>
                <td>{{ ucfirst($user->status) }}</td>

                <td>
                    <a href="{{ route('form.edit.pengguna.internal', $user->id) }}">Edit</a> |
                    <form action="{{ route('hapus.pengguna.internal', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" style="background:none; border:none; padding:0; color:blue; text-decoration:underline; cursor:pointer;">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data pengguna internal untuk ditampilkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

@endsection
