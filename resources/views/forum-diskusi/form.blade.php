@extends('layouts.dashboard')

@section('title', isset($discussion) ? 'Edit Forum Diskusi' : 'Tambah Forum Diskusi Baru')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            {{ isset($discussion) ? 'Edit Forum Diskusi' : 'Tambah Forum Diskusi Baru' }}
        </h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form action="{{ isset($discussion) ? route('edit.forum.diskusi', $discussion->id) : route('tambah.forum.diskusi') }}" method="POST" class="discussion-form">
        @csrf
        @if(isset($discussion))
            @method('PUT')
        @endif

        <div class="form-layout">
            <div class="form-main">
                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">Judul Diskusi <span class="required">*</span></label>
                    <input type="text" class="form-input @error('title') error @enderror" 
                           id="title" name="title" 
                           value="{{ old('title', $discussion->title ?? '') }}" 
                           placeholder="Masukkan judul diskusi" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content" class="form-label">Isi Diskusi <span class="required">*</span></label>
                    <textarea class="form-textarea @error('content') error @enderror" 
                              id="content" name="content" rows="10" 
                              placeholder="Tulis isi diskusi Anda di sini..." required>{{ old('content', $discussion->content ?? '') }}</textarea>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-sidebar">
                <!-- Category -->
                <div class="form-group">
                    <label for="forum_category_id" class="form-label">Kategori <span class="required">*</span></label>
                    <select class="form-select @error('forum_category_id') error @enderror" 
                            id="forum_category_id" name="forum_category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('forum_category_id', $discussion->forum_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('forum_category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <a href="{{ route('forum.diskusi') }}" class="btn btn-secondary">
                ← Kembali
            </a>
            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">
                    {{ isset($discussion) ? 'Update Diskusi' : 'Buat Diskusi' }}
                </button>
            </div>
        </div>
    </form>
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

.form-container {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
}

.form-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    margin-bottom: 2rem;
}

.form-main {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.required {
    color: #ef4444;
}

.form-input,
.form-textarea,
.form-select {
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background-color: white;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.error,
.form-textarea.error,
.form-select.error {
    border-color: #ef4444;
}

.form-textarea {
    resize: vertical;
    min-height: 200px;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
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

@media (max-width: 1024px) {
    .form-layout {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .form-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .form-container {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .action-buttons {
        justify-content: center;
    }
}
</style>
@endsection 