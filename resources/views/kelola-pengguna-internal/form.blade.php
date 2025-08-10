@extends('layouts.dashboard')

@section('title', isset($user) ? 'Edit Pengguna Internal' : 'Tambah Pengguna Internal')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($user) ? 'Edit Pengguna Internal' : 'Tambah Pengguna Internal' }}</h1>
</div>

@if(isset($user) && $user->custom_id)
    <div class="mb-4 p-3 bg-gray-50 rounded">
        <p class="text-sm text-gray-600 mb-1">ID Pengguna:</p>
        <p class="font-medium text-lg">{{ $user->custom_id }}</p>
    </div>
    @endif

    <form action="{{ isset($user) ? route('edit.pengguna.internal', $user->id) : route('tambah.pengguna.internal') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="grid grid-cols-2 gap-6">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control @error('name') error @enderror" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') error @enderror" {{ isset($user) ? '' : 'required' }}>
                @if(isset($user))
                    <small class="text-gray-500 text-sm">Kosongkan jika tidak ingin mengubah password.</small>
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
                <select id="status" name="status" class="form-control @error('status') error @enderror" required>
                    <option value="aktif" {{ old('status', $user->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ old('status', $user->status ?? '') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role_id">Role</label>
                <select id="role_id" name="role_id" class="form-control @error('role_id') error @enderror" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="flex gap-4 form-actions mt-6">
            <a href="{{ route('daftar.pengguna.internal') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}</button>
        </div>
    </form>
@endsection
