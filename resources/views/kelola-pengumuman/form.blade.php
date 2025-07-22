@extends('layouts.dashboard')

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($announcement) ? route('edit.kelola.pengumuman', $announcement->id) : route('tambah.kelola.pengumuman') }}" method="POST">
            @csrf
            @if (isset($announcement))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">Judul Pengumuman</label>
                <input type="text" class="form-control @error('title') error @enderror" id="title" name="title" value="{{ old('title', $announcement->title ?? '') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="published_date">Tanggal Publikasi</label>
                <input type="date" class="form-control @error('published_date') error @enderror" id="published_date" name="published_date" value="{{ old('published_date', $announcement->published_date ?? '') }}" required>
                @error('published_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Isi Pengumuman</label>
                <trix-editor 
                    id="content" 
                    name="content" 
                    class="trix-content @error('content') error @enderror"
                    placeholder="Tulis isi pengumuman di sini..."
                ></trix-editor>
                <input type="hidden" name="content" id="content-input" value="{{ old('content', $announcement->content ?? '') }}">
                @error('content')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('daftar.kelola.pengumuman') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<!-- Trix Editor CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trixEditor = document.querySelector('trix-editor');
    const hiddenInput = document.getElementById('content-input');
    
    // Load existing content into Trix editor
    if (hiddenInput.value) {
        trixEditor.value = hiddenInput.value;
    }
    
    // Sync trix editor content with hidden input before form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        hiddenInput.value = trixEditor.value;
    });
    
    // Handle trix change events
    trixEditor.addEventListener('trix-change', function() {
        hiddenInput.value = trixEditor.value;
    });
    
    // Handle trix file accept for attachments
    trixEditor.addEventListener('trix-file-accept', function(e) {
        // Allow images only
        if (!e.file.type.match(/^image\//)) {
            e.preventDefault();
            alert('Hanya file gambar yang diperbolehkan.');
        }
        
        // Limit file size to 5MB
        if (e.file.size > 5 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file maksimal 5MB.');
        }
    });
    
    // Handle trix attachment add for file uploads
    trixEditor.addEventListener('trix-attachment-add', function(e) {
        const attachment = e.attachment;
        if (attachment.file) {
            // Here you would typically upload the file to your server
            // and set the attachment's URL attribute
            console.log('File attached:', attachment.file.name);
            
            // For now, we'll just show a placeholder
            attachment.setAttributes({
                url: '#',
                href: '#'
            });
        }
    });
});
</script>
@endsection
