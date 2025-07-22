@extends('layouts.dashboard')

@section('title', 'Akses Pengumuman')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Akses Pengumuman</h1>
        <p class="text-gray-600">Lihat semua pengumuman yang telah dipublikasikan</p>
    </div>
</div>

<div class="search-container mb-6">
    <div class="search-bar">
        <input type="text" class="form-control" placeholder="🔍 Cari pengumuman..." id="searchAnnouncement">
    </div>
</div>

<div class="announcement-grid">
    @forelse($announcements as $announcement)
    <div class="announcement-card" data-title="{{ strtolower($announcement->title) }}" data-content="{{ strtolower(strip_tags($announcement->content)) }}">
        <div class="announcement-card-header">
            <div class="announcement-meta">
                <span class="announcement-date">{{ \Carbon\Carbon::parse($announcement->published_date)->format('d M Y') }}</span>
                <span class="announcement-author">oleh {{ $announcement->user->nama ?? 'Admin' }}</span>
            </div>
        </div>
        <div class="announcement-card-body">
            <h3 class="announcement-title">{{ $announcement->title }}</h3>
            <div class="announcement-preview">
                {!! \Illuminate\Support\Str::limit(strip_tags($announcement->content), 150, '...') !!}
            </div>
        </div>
        <div class="announcement-card-footer">
            <a href="{{ route('akses.pengumuman.detail', $announcement->id) }}" class="btn btn-primary btn-sm">
                📖 Baca Selengkapnya
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">📢</div>
        <h3>Belum ada pengumuman</h3>
        <p class="text-gray-500">Belum ada pengumuman yang dipublikasikan saat ini.</p>
    </div>
    @endforelse
</div>

<script>
document.getElementById('searchAnnouncement').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const announcementCards = document.querySelectorAll('.announcement-card');
    
    announcementCards.forEach(card => {
        const title = card.getAttribute('data-title');
        const content = card.getAttribute('data-content');
        
        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection 