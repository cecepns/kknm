@extends('layouts.dashboard')

@section('title', 'Detail Forum Diskusi')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Forum Diskusi</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="detail-container">
    <!-- Discussion Header -->
    <div class="discussion-header">
        <div class="discussion-title-section">
            <h2 class="discussion-title">{{ $discussion->title }}</h2>
            <div class="discussion-meta">
                <span class="meta-item">
                    <i class="fas fa-user"></i> Oleh {{ $discussion->user->name }}
                </span>
                <span class="meta-item">
                    <i class="fas fa-calendar"></i> {{ $discussion->created_at->format('d M Y') }}
                </span>
                <span class="category-badge">{{ $discussion->category->name }}</span>
            </div>
        </div>
        <div class="discussion-actions">
            <a href="{{ route('forum.diskusi') }}" class="btn btn-secondary">
                ← Kembali
            </a>
            @if(auth()->id() == $discussion->user_id)
                <a href="{{ route('form.edit.forum.diskusi', $discussion->id) }}" class="btn btn-outline">
                    ✏️ Edit
                </a>
                <form action="{{ route('hapus.forum.diskusi', $discussion->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus diskusi ini?')">
                        🗑️ Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Discussion Content -->
    <div class="discussion-content">
        <div class="content-body">
            {{ $discussion->content }}
        </div>
        <div class="content-stats">
            <span class="stat-item">
                <i class="fas fa-comment"></i> {{ $discussion->comments_count }} Komentar
            </span>
            <span class="stat-item">
                <i class="fas fa-thumbs-up"></i> {{ $discussion->likes_count }} Suka
            </span>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
        <h3 class="section-title">Komentar</h3>
        
        <div class="comments-list">
            @forelse($discussion->comments as $comment)
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="comment-author">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="author-info">
                                <span class="author-name">{{ $comment->user->name }}</span>
                                <span class="comment-date">{{ $comment->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-body">
                        {{ $comment->content }}
                    </div>T
                </div>
            @empty
                <div class="empty-comments">
                    <div class="empty-icon">💬</div>
                    <h4>Belum ada komentar</h4>
                    <p>Jadilah yang pertama berkomentar!</p>
                </div>
            @endforelse
        </div>

        <!-- Add Comment Form -->
        <div class="add-comment">
            <h4 class="form-title">Tambah Komentar</h4>
            <form action="{{ route('tambah.komentar', $discussion->id) }}" method="POST" class="comment-form">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-textarea" rows="4" placeholder="Tulis komentar Anda di sini..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

.detail-container {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
}

.discussion-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.discussion-title-section {
    flex: 1;
    margin-right: 2rem;
}

.discussion-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 1rem 0;
    line-height: 1.3;
}

.discussion-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    color: #6b7280;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.category-badge {
    background-color: #3b82f6;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.discussion-actions {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
}

.discussion-content {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.content-body {
    font-size: 1rem;
    line-height: 1.6;
    color: #374151;
    margin-bottom: 1rem;
    white-space: pre-wrap;
}

.content-stats {
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

.comments-section {
    margin-top: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1.5rem;
}

.comments-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.comment-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.comment-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.author-avatar {
    width: 32px;
    height: 32px;
    background: #3b82f6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.author-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.875rem;
}

.comment-date {
    color: #6b7280;
    font-size: 0.75rem;
}

.btn-delete {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.btn-delete:hover {
    background-color: #fef2f2;
}

.comment-body {
    color: #374151;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
    white-space: pre-wrap;
}

.comment-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    background: none;
    border: 1px solid #d1d5db;
    color: #6b7280;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.action-btn:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
}

.empty-comments {
    text-align: center;
    padding: 2rem 1rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
}

.empty-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.empty-comments h4 {
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-comments p {
    color: #6b7280;
    margin: 0;
}

.add-comment {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
}

.form-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
}

.comment-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background-color: white;
    resize: vertical;
    min-height: 100px;
}

.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.btn-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
    border-color: #6b7280;
}

.btn-secondary:hover {
    background-color: #4b5563;
    border-color: #4b5563;
}

.btn-outline {
    background-color: white;
    color: #374151;
    border-color: #d1d5db;
}

.btn-outline:hover {
    background-color: #f9fafb;
    border-color: #9ca3af;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
    border-color: #ef4444;
}

.btn-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
}

@media (max-width: 768px) {
    .detail-container {
        padding: 1rem;
    }
    
    .discussion-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .discussion-title-section {
        margin-right: 0;
    }
    
    .discussion-actions {
        justify-content: flex-start;
        flex-wrap: wrap;
    }
    
    .discussion-meta {
        gap: 0.5rem;
    }
    
    .meta-item {
        font-size: 0.75rem;
    }
}
</style>
@endsection 