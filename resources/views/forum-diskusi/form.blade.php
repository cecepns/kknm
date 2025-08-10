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
                <input type="text" class="form-control @error('title') error @enderror" 
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
                <textarea class="form-control @error('content') error @enderror" 
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
                <select class="form-control @error('forum_category_id') error @enderror" 
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
            Batal
        </a>
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                {{ isset($discussion) ? 'Update Diskusi' : 'Buat Diskusi' }}
            </button>
        </div>
    </div>
</form>

 
@endsection 