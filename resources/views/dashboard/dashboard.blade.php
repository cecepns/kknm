@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-welcome">
    <h1 class="welcome-title">{{ $welcomeMessage ?? 'Selamat Datang' }}</h1>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-label">Total Pengetahuan Diunggah</div>
            <div class="stat-number">{{ $stats['totalUploaded'] ?? 0 }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-label">Total Pengetahuan Tervalidasi</div>
            <div class="stat-number">{{ $stats['totalValidated'] ?? 0 }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-label">Total Pengetahuan Ditolak</div>
            <div class="stat-number">{{ $stats['totalRejected'] ?? 0 }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-label">Total Forum Diikuti</div>
            <div class="stat-number">{{ $stats['totalForums'] ?? 0 }}</div>
        </div>
    </div>
</div>

<!-- Quick Access Section -->
<div class="quick-access-section">
    <h2 class="section-title">Akses Cepat</h2>
    <div class="quick-access-grid">
        @foreach($quickAccessLinks ?? [] as $link)
        <a href="{{ $link['url'] }}" class="quick-access-card">
            <div class="quick-access-text">{{ $link['title'] }}</div>
        </a>
        @endforeach
    </div>
</div>
@endsection