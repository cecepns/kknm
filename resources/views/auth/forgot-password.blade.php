@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Lupa Password</h1>
            <p class="auth-subtitle">Masukkan email Anda untuk reset password</p>
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

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf
                
                <div class="auth-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="auth-submit">Kirim Link Reset Password</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>Ingat password Anda? <a href="{{ route('login') }}" class="auth-link">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection
