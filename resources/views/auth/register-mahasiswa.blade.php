@extends('layouts.app')

@section('title', 'Register Mahasiswa KKN')

@section('content')
<div class="container">
    <h2>Register Mahasiswa KKN</h2>

    <div class="tabs">
        <a href="{{ route('register.mahasiswa') }}" class="tab-link">Mahasiswa KKN</a>
        <a href="{{ route('register.dosen') }}" class="tab-link active">Dosen Pembimbing Lapangan</a>
    </div>

    <form method="POST" action="{{ route('register.mahasiswa') }}">
        @csrf

        <div class="form-column">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                @error('name')
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
                <label for="student_id">NIM</label>
                <input type="text" id="student_id" name="student_id" class="form-control" value="{{ old('student_id') }}" required>
                @error('student_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="faculty">Fakultas</label>
                <select id="faculty" name="faculty" class="form-control" required>
                    <option value="">Pilih Fakultas</option>
                    @foreach($fakultas as $item)
                        <option value="{{ $item['value'] }}" {{ old('faculty') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('faculty')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-column">
            <div class="form-group">
                <label for="study_program">Program Studi (Prodi)</label>
                <select id="study_program" name="study_program" class="form-control" required>
                    <option value="">Pilih Program Studi</option>
                    @foreach($program_studi as $item)
                        <option value="{{ $item['value'] }}" {{ old('study_program') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('study_program')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="batch_year">Angkatan</label>
                <select id="batch_year" name="batch_year" class="form-control" required>
                    <option value="">Pilih Angkatan</option>
                    @foreach($angkatan as $tahun)
                        <option value="{{ $tahun }}" {{ old('batch_year') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                @error('batch_year')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kkn_type">Jenis KKN</label>
                <select id="kkn_type" name="kkn_type" class="form-control" required>
                    <option value="">Pilih Jenis KKN</option>
                    @foreach($jenis_kkn as $item)
                        <option value="{{ $item['value'] }}" {{ old('kkn_type') == $item['value'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach
                </select>
                @error('kkn_type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kkn_group_number">No Kelompok KKN</label>
                <select id="kkn_group_number" name="kkn_group_number" class="form-control" required>
                    <option value="">Pilih Nomor Kelompok KKN</option>
                    @foreach($no_kelompok_kkn as $no_kelompok)
                        <option value="{{ $no_kelompok }}" {{ old('kkn_group_number') == $no_kelompok ? 'selected' : '' }}>{{ $no_kelompok }}</option>
                    @endforeach
                </select>
                @error('kkn_group_number')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kkn_location">Lokasi KKN</label>
                <input type="text" id="kkn_location" name="kkn_location" class="form-control" value="{{ old('kkn_location') }}" required>
                @error('kkn_location')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kkn_year">Tahun KKN</label>
                <select id="kkn_year" name="kkn_year" class="form-control" required>
                    <option value="">Pilih Tahun KKN</option>
                    @foreach($tahun_kkn as $tahun)
                        <option value="{{ $tahun }}" {{ old('kkn_year') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                @error('kkn_year')
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
