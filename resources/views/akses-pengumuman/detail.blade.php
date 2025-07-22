@extends('layouts.dashboard')

@section('title', $announcement->title)

@section('content')
<div class="announcement-detail-container">
    <!-- Back Button -->
    <div class="back-navigation mb-6">
        <a href="{{ route('akses.pengumuman') }}" class="btn btn-secondary">
            ← Kembali ke Daftar Pengumuman
        </a>
    </div>

    <!-- Announcement Header -->
    <div class="announcement-detail-header">
        <div class="announcement-meta">
            <span class="announcement-date">
                📅 {{ \Carbon\Carbon::parse($announcement->published_date)->format('d F Y') }}
            </span>
            <span class="announcement-author">
                👤 {{ $announcement->user->nama ?? 'Admin' }}
            </span>
        </div>
        <h1 class="announcement-detail-title">{{ $announcement->title }}</h1>
    </div>

    <!-- Announcement Content -->
    <div class="announcement-detail-content">
        <div class="content-wrapper">
            {!! $announcement->content !!}
        </div>
    </div>

    <!-- Share Section -->
    <div class="announcement-share mt-8">
        <h3>Bagikan Pengumuman</h3>
        <div class="share-buttons">
            <button class="btn btn-secondary btn-sm" onclick="copyToClipboard(window.location.href)">
                📋 Salin Link
            </button>
            <a href="https://wa.me/?text={{ urlencode($announcement->title . ' - ' . request()->url()) }}" 
               target="_blank" class="btn btn-success btn-sm">
                📱 WhatsApp
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($announcement->title . ' - ' . request()->url()) }}" 
               target="_blank" class="btn btn-info btn-sm">
                🐦 Twitter
            </a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = '✅ Tersalin!';
        button.classList.add('btn-success');
        button.classList.remove('btn-secondary');
        
        setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin link');
    });
}
</script>
@endsection 