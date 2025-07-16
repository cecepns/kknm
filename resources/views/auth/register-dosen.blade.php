@extends('layouts.app')

@section('title', 'Register Dosen Pembimbing Lapangan')

@section('content')
<div class="container">
    <h2>Register</h2>
    <p>Daftar akun sesuai dengan peran</p>

    <div class="tabs">
        <a href="{{ route('register.mahasiswa') }}" class="tab-link">Mahasiswa KKN</a>
        <a href="{{ route('register.dosen') }}" class="tab-link active">Dosen Pembimbing Lapangan</a>
    </div>

    <form method="POST" action="{{ route('register.dosen') }}">
        @csrf

        <div class="form-column">
            <div class="form-group">
                <label for="nip_nidn">NIP/NIDN</label>
                <input type="text" id="nip_nidn" name="nip_nidn" class="form-control" value="{{ old('nip_nidn') }}" required autofocus>
                @error('nip_nidn')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="form-column">
            <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <select id="fakultas" name="fakultas" class="form-control" required>
                    <option value="">Pilih Fakultas</option>
                    @foreach($fakultas as $item)
                        <option value="{{ $item['value'] }}" {{ old('fakultas') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('fakultas')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="program_studi">Program Studi (Prodi)</label>
                <select id="program_studi" name="program_studi" class="form-control" required>
                    <option value="">Pilih Program Studi</option>
                    @foreach($program_studi as $item)
                        <option value="{{ $item['value'] }}" {{ old('program_studi') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('program_studi')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="justify-content: flex-end; flex-grow: 1;">
                 <button type="submit" class="btn">Register</button>
            </div>
        </div>

        <div class="form-full-width">
            <p class="link">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </form>
</div>
@endsection
