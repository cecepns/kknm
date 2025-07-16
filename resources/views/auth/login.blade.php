@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <h2>Form Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        @error('email')
            <div class="error-message" style="margin-bottom: 15px; text-align:center;">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn">Login</button>
    </form>
    <p class="link">Belum punya akun? <a href="{{ route('register') }}">Register di sini</a></p>
</div>
@endsection