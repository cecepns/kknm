@extends('layouts.app')

@section('title', 'Register Mahasiswa KKN')

@section('content')
<div class="container">
    <h2>Register Mahasiswa KKN</h2>
    <p>Daftar akun sesuai dengan peran</p>

    <form method="POST" action="{{ route('register.mahasiswa') }}">
        @csrf

        {{-- Kolom Kiri --}}
        <div class="form-column">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required autofocus>
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

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" value="{{ old('nim') }}" required>
                @error('nim')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

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
        </div>

        {{-- Kolom Kanan --}}
        <div class="form-column">
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

            <div class="form-group">
                <label for="angkatan">Angkatan</label>
                <select id="angkatan" name="angkatan" class="form-control" required>
                    <option value="">Pilih Angkatan</option>
                    @foreach($angkatan as $tahun)
                        <option value="{{ $tahun }}" {{ old('angkatan') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                @error('angkatan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kkn">Jenis KKN</label>
                <select id="jenis_kkn" name="jenis_kkn" class="form-control" required>
                    <option value="">Pilih Jenis KKN</option>
                    @foreach($jenis_kkn as $item)
                        <option value="{{ $item['value'] }}" {{ old('jenis_kkn') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('jenis_kkn')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_kelompok_kkn">No Kelompok KKN</label>
                <select id="no_kelompok_kkn" name="no_kelompok_kkn" class="form-control" required>
                    <option value="">Pilih Nomor Kelompok KKN</option>
                    @foreach($no_kelompok_kkn as $no_kelompok)
                        <option value="{{ $no_kelompok }}" {{ old('no_kelompok_kkn') == $no_kelompok ? 'selected' : '' }}>{{ $no_kelompok }}</option>
                    @endforeach
                </select>
                @error('no_kelompok_kkn')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lokasi_kkn">Lokasi KKN</label>
                <input type="text" id="lokasi_kkn" name="lokasi_kkn" class="form-control" value="{{ old('lokasi_kkn') }}" required>
                @error('lokasi_kkn')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tahun_kkn">Tahun KKN</label>
                <select id="tahun_kkn" name="tahun_kkn" class="form-control" required>
                    <option value="">Pilih Tahun KKN</option>
                    @foreach($tahun_kkn as $tahun)
                        <option value="{{ $tahun }}" {{ old('tahun_kkn') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                @error('tahun_kkn')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-full-width">
            <button type="submit" class="btn">Register</button>
            <p class="link">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </form>
</div>
@endsection
