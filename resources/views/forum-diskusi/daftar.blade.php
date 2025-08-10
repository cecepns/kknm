@extends('layouts.dashboard')

@section('title', 'Forum Diskusi')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Forum Diskusi</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="search-container">
    <div class="search-bar">
        <form action="{{ route('forum.diskusi') }}" method="GET" class="d-flex">
            <input type="text" class="form-control" name="search" placeholder="Cari diskusi..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>
    </div>
    <a href="{{ route('form.tambah.forum.diskusi') }}" class="btn btn-primary">
        Tambah Forum Diskusi
    </a>
</div>

<!-- Category Filters -->
<div class="category-section">
    <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">Kategori Diskusi</h2>
    <div class="category-filters">
        <a href="{{ route('forum.diskusi') }}" class="category-btn {{ !request('category') || request('category') == 'semua' ? 'active' : '' }}">
            Semua
        </a>
        @foreach($categories as $category)
            <a href="{{ route('forum.diskusi', ['category' => $category->name]) }}" 
               class="category-btn {{ request('category') == $category->name ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</div>

<!-- Discussion List -->
<div class="discussion-section">
    <div class="discussion-grid">
        @forelse($discussions as $discussion)
            <div class="discussion-card">
                <div class="discussion-card-header">
                    <h3 class="discussion-title">
                        <a href="{{ route('forum.diskusi.detail', $discussion->id) }}" class="text-decoration-none">
                            {{ $discussion->title }}
                        </a>
                    </h3>
                    <span class="category-badge">{{ $discussion->category->name }}</span>
                </div>
                <div class="discussion-card-body">
                    <p class="discussion-meta">
                        {{ $discussion->created_at->format('d M Y') }} - 
                        Dimulai oleh {{ $discussion->user->name }}
                    </p>
                    <div class="discussion-stats">
                        <span class="stat-item">
                            <i class="fas fa-comment"></i> {{ $discussion->comments_count }} Komentar
                        </span>
                        <span class="stat-item">
                            <i class="fas fa-thumbs-up"></i> {{ $discussion->likes_count }} Suka
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">💬</div>
                <h3>Belum ada diskusi</h3>
                <p class="text-gray-500">Mulai diskusi pertama Anda!</p>
                <a href="{{ route('form.tambah.forum.diskusi') }}" class="btn btn-primary">Buat Diskusi Pertama</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($discussions->hasPages())
    <div class="pagination-container">
        {{ $discussions->links() }}
    </div>
@endif

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}

.search-bar {
    flex: 1;
    max-width: 500px;
}

.search-bar form {
    display: flex;
    gap: 0.5rem;
}

.search-bar input {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 0.75rem 1rem;
}

.search-bar button {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
}

.category-section {
    margin-bottom: 2rem;
}

/* ANCHOR: Responsive search-bar */
@media (max-width: 640px) {
    .search-container {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    .search-bar {
        max-width: 100%;
        width: 100%;
    }
    .search-bar form {
        flex-direction: column;
        gap: 0.5rem;
    }
    .search-bar input,
    .search-bar button {
        width: 100%;
        box-sizing: border-box;
    }
}


.category-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.category-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    text-decoration: none;
    color: #6b7280;
    background-color: white;
    transition: all 0.2s;
}

.category-btn:hover {
    background-color: #f3f4f6;
    color: #374151;
    text-decoration: none;
}

.category-btn.active {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.discussion-section {
    margin-bottom: 2rem;
}

.discussion-grid {
    display: grid;
    gap: 1rem;
}

.discussion-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.2s;
}

.discussion-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border-color: #d1d5db;
}

.discussion-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.discussion-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    flex: 1;
    margin-right: 1rem;
}

.discussion-title a {
    color: #1e293b;
    text-decoration: none;
}

.discussion-title a:hover {
    color: #3b82f6;
}

.category-badge {
    background-color: #f3f4f6;
    color: #374151;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
}

.discussion-card-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.discussion-meta {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0;
}

.discussion-stats {
    display: flex;
    gap: 1rem;
}

.stat-item {
    color: #6b7280;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.text-gray-500 {
    color: #6b7280;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .search-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-bar {
        max-width: none;
    }
    
    .discussion-card-body {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .discussion-stats {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
@endsection 