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

<!-- CSRF Token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Custom styles for Trix editor file uploads */
    .trix-content {
        min-height: 200px;
    }

    .trix-attachment {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px;
        margin: 4px 0;
        background: #f9f9f9;
        transition: all 0.3s ease;
    }

    .trix-attachment__caption {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    /* Loading animation for file uploads - Removed as we now use simple text placeholder */

    /* Image styling in editor */
    .trix-content img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
        position: relative;
        cursor: pointer;
    }

    .trix-content img:hover {
        transform: scale(1.02);
    }

    /* File link styling */
.trix-content a[download] {
    display: inline-block;
    padding: 8px 12px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    text-decoration: none;
    color: #495057;
    margin: 4px 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
    position: relative;
}

.trix-content a[download]:hover {
    background: #e9ecef;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Uploading placeholder styling */
.uploading-placeholder {
    display: inline-block;
    padding: 8px 12px;
    background: #e3f2fd;
    border: 1px solid #2196f3;
    border-radius: 4px;
    color: #1976d2;
    font-style: italic;
    margin: 4px 0;
    animation: pulse-upload 1.5s ease-in-out infinite;
}

@keyframes pulse-upload {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Notification animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

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
    
    // Handle trix initialize
    trixEditor.addEventListener('trix-initialize', function() {
        console.log('Trix editor initialized');
    });
    
    // Handle trix render
    trixEditor.addEventListener('trix-render', function() {
        console.log('Trix editor rendered');
    });
    
    // Handle trix file accept for attachments
    trixEditor.addEventListener('trix-file-accept', function(e) {
        // Allow images, PDFs, and documents
        const allowedTypes = [
            'image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp',
            'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain'
        ];
        
        if (!allowedTypes.includes(e.file.type)) {
            e.preventDefault();
            alert('Tipe file tidak didukung. Gunakan gambar, PDF, Word, atau file teks.');
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
            uploadFile(attachment);
        }
    });
    
    // Handle trix attachment remove
    trixEditor.addEventListener('trix-attachment-remove', function(e) {
        console.log('Attachment removed:', e.attachment);
    });
    
    /**
     * ANCHOR: Upload file to server and update attachment
     * Handle file upload for Trix editor attachments
     */
    function uploadFile(attachment) {
        const formData = new FormData();
        formData.append('file', attachment.file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Get the trix editor element
        const trixEditor = document.querySelector('trix-editor');
        
        // Show upload progress
        const isImage = attachment.file.type.startsWith('image/');
        const uploadType = isImage ? 'gambar' : 'file';
        
        fetch('{{ route("upload.file.pengumuman") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Re-enable editor
            if (trixEditor) {
                trixEditor.setAttribute('contenteditable', 'true');
                trixEditor.style.opacity = '1';
                trixEditor.style.pointerEvents = 'auto';
            }

			attachment.remove();		
            
            if (data.success) {
                // Remove the uploading placeholder first
                const uploadingPlaceholder = trixEditor.querySelector('.uploading-placeholder');
                if (uploadingPlaceholder) {
                    uploadingPlaceholder.remove();
                }
                
                // Then insert the actual content
                const isImage = attachment.file.type.startsWith('image/');
                
                if (isImage) {
                    // For images, insert the image HTML
                    const imageHTML = `
                        <div style="position: relative; display: inline-block; margin: 10px 0;">
                            <img src="${data.url}" alt="${attachment.file.name}" style="max-width: 100%; height: auto; display: block; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    `;
                    trixEditor.editor.insertHTML(imageHTML);
                } else {
                    // For non-image files, insert a download link
                    const fileSize = formatFileSize(attachment.file.size);
                    const fileLinkHTML = `
                        <a href="${data.url}" download="${attachment.file.name}" style="display: inline-block; padding: 8px 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; text-decoration: none; color: #495057; margin: 4px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <span style="margin-right: 8px;">📎</span>${attachment.file.name} (${fileSize})
                        </a>
                    `;
                    trixEditor.editor.insertHTML(fileLinkHTML);
                }
                
                // Debug: log the upload success
                console.log('File uploaded successfully:', data.url);
            } else {
                // Show error and remove uploading placeholder
                const uploadingPlaceholder = trixEditor.querySelector('.uploading-placeholder');
                if (uploadingPlaceholder) {
                    uploadingPlaceholder.remove();
                }
            }
        })
        .catch(error => {
            // Re-enable editor
            if (trixEditor) {
                trixEditor.setAttribute('contenteditable', 'true');
                trixEditor.style.opacity = '1';
                trixEditor.style.pointerEvents = 'auto';
            }
            
            // Remove uploading placeholder on error
            const uploadingPlaceholder = trixEditor.querySelector('.uploading-placeholder');
            if (uploadingPlaceholder) {
                uploadingPlaceholder.remove();
            }
            
            console.error('Upload error:', error);
        });
    }
    
    /**
     * ANCHOR: Format file size for display
     * Convert bytes to human readable format
     */
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endsection
