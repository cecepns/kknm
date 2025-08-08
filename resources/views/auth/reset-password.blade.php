@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Masukkan password baru Anda</p>
        </div>
        
        <div class="auth-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="auth-form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="auth-form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="auth-submit">Reset Password</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>Ingat password Anda? <a href="{{ route('login') }}" class="auth-link">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection
