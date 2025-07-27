@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-welcome">
    <h1 class="welcome-title">{{ $welcomeMessage ?? 'Selamat Datang' }}</h1>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    @if(isset($stats['totalUsers']))
        <!-- Admin Statistics -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-number">{{ $stats['totalUsers'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Masuk</div>
                <div class="stat-number">{{ $stats['totalKnowledge'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Forum Aktif</div>
                <div class="stat-number">{{ $stats['totalActiveForums'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total File Repositori</div>
                <div class="stat-number">{{ $stats['totalRepositoryFiles'] ?? 0 }}</div>
            </div>
        </div>
    @elseif(isset($stats['totalUnverified']))
        <!-- Verifikator Statistics -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Belum Diverifikasi</div>
                <div class="stat-number">{{ $stats['totalUnverified'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Terverifikasi</div>
                <div class="stat-number">{{ $stats['totalVerified'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Terklasifikasi</div>
                <div class="stat-number">{{ $stats['totalClassified'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total File Repositori Publik</div>
                <div class="stat-number">{{ $stats['totalRepositoryFiles'] ?? 0 }}</div>
            </div>
        </div>
    @elseif(isset($stats['totalUnvalidated']))
        <!-- Kepala PPM Statistics -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Masuk</div>
                <div class="stat-number">{{ $stats['totalKnowledge'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pengetahuan Belum Divalidasi</div>
                <div class="stat-number">{{ $stats['totalUnvalidated'] ?? 0 }}</div>
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
                <div class="stat-label">Total File Repositori Publik</div>
                <div class="stat-number">{{ $stats['totalRepositoryFiles'] ?? 0 }}</div>
            </div>
        </div>
    @else
        <!-- User Statistics -->
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
    @endif
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