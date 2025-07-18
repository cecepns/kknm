@extends('layouts.dashboard')

@section('title', isset($user) ? 'Edit Pengguna Internal' : 'Tambah Pengguna Internal')

@section('content')

    <header>
        <h1>{{ isset($user) ? 'Edit Pengguna Internal' : 'Tambah Pengguna Internal' }}</h1>
    </header>

    <hr>

    <form action="{{ isset($user) ? route('edit.pengguna.internal', $user->id) : route('tambah.pengguna.internal') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $user->nama ?? '') }}" required>
            @error('nama')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            @if(isset($user))
                <small>Kosongkan jika tidak ingin mengubah password.</small>
            @endif
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="aktif" {{ old('status', $user->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ old('status', $user->status ?? '') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select id="role_id" name="role_id" class="form-control" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn">{{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}</button>
            <a href="{{ route('daftar.pengguna.internal') }}" class="btn-secondary">Batal</a>
        </div>
    </form>

@endsection
