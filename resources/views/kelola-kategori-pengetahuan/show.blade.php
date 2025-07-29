@extends('layouts.dashboard')

@section('title', 'Detail Kategori Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Kategori Pengetahuan</h1>
    </div>
    <div>
        <a href="{{ route('kelola.kategori.pengetahuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- ANCHOR: Category Details -->
<div class="detail-container">
    <div class="detail-section">
        <h3 class="section-title">Informasi Kategori</h3>
        <div class="detail-content">
            <div class="detail-item">
                <span class="label">Nama Kategori:</span>
                <span class="value">{{ $knowledgeCategory->name }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jumlah Pengetahuan:</span>
                <span class="value">{{ $knowledgeCategory->knowledgeItems()->count() }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tanggal Dibuat:</span>
                <span class="value">{{ $knowledgeCategory->created_at->format('d F Y H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Terakhir Diupdate:</span>
                <span class="value">{{ $knowledgeCategory->updated_at->format('d F Y H:i') }}</span>
            </div>
        </div>
    </div>

    @if($knowledgeCategory->knowledgeItems()->count() > 0)
    <div class="detail-section">
        <h3 class="section-title">Daftar Pengetahuan dalam Kategori Ini</h3>
        <div class="knowledge-list">
            @foreach($knowledgeCategory->knowledgeItems()->orderBy('created_at', 'desc')->get() as $knowledge)
                <div class="knowledge-item">
                    <div class="knowledge-info">
                        <h4 class="knowledge-title">{{ $knowledge->title }}</h4>
                        <p class="knowledge-meta">
                            Diunggah oleh: {{ $knowledge->user->name }} | 
                            {{ $knowledge->created_at->format('d F Y') }} | 
                            Status: {{ $knowledge->status_label }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
.detail-container {
    margin-top: 2rem;
}

.detail-section {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    overflow: hidden;
}

.section-title {
    background-color: #f8f9fa;
    padding: 1rem;
    margin: 0;
    border-bottom: 1px solid #e9ecef;
    font-size: 1.25rem;
    color: #495057;
}

.detail-content {
    padding: 1.5rem;
}

.detail-item {
    display: flex;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f3f4;
}

.detail-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: #495057;
    min-width: 150px;
}

.value {
    color: #6c757d;
}

.knowledge-list {
    padding: 1.5rem;
}

.knowledge-item {
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
    background-color: #f8f9fa;
}

.knowledge-item:last-child {
    margin-bottom: 0;
}

.knowledge-title {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    color: #495057;
}

.knowledge-meta {
    margin: 0;
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endsection 