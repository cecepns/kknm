@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Login</h1>
            <p class="auth-subtitle">Masuk ke akun KMS KKN Anda</p>
        </div>
        
        <div class="auth-body">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                
                <div class="auth-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="auth-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="auth-submit">Login</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ route('register.mahasiswa') }}" class="auth-link">Register di sini</a></p>
        </div>
    </div>
</div>
@endsection