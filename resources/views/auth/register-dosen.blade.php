@extends('layouts.app')

@section('title', 'Register Dosen Pembimbing Lapangan')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Register Dosen</h1>
            <p class="auth-subtitle">Daftar akun sesuai dengan peran</p>
        </div>
        
        <div class="auth-body">
            <div class="auth-tabs">
                <a href="{{ route('register.mahasiswa') }}" class="auth-tab">Mahasiswa KKN</a>
                <a href="{{ route('register.dosen') }}" class="auth-tab active">Dosen Pembimbing Lapangan</a>
            </div>
            
            <form method="POST" action="{{ route('register.dosen') }}" class="auth-form">
                @csrf
                
                <div class="auth-form-row">
                    <div class="auth-form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="auth-form-row">
                    <div class="auth-form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="auth-form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                
                <div class="auth-form-row">
                    <div class="auth-form-group">
                        <label for="employee_id">NIP/NIDN</label>
                        <input type="text" id="employee_id" name="employee_id" class="form-control" value="{{ old('employee_id') }}" required autofocus>
                        @error('employee_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="auth-form-group">
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
                
                
                <div class="auth-form-group">
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
                
                <button type="submit" class="auth-submit">Register</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login</a></p>
        </div>
    </div>
</div>
@endsection
