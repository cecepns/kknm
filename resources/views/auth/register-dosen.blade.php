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
                <label for="employee_id">NIP/NIDN</label>
                <input type="text" id="employee_id" name="employee_id" class="form-control" value="{{ old('employee_id') }}" required autofocus>
                @error('employee_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
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
        </div>

        <div class="form-column">
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
