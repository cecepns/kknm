@extends('layouts.dashboard')

@section('title', isset($knowledge) ? 'Edit Pengetahuan - KMS KKN' : 'Unggah Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ isset($knowledge) ? 'Edit Pengetahuan' : 'Unggah Pengetahuan' }}</h1>
    </div>
</div>

<!-- ANCHOR: Flash Messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<form action="{{ isset($knowledge) ? route('unggah.pengetahuan.update', $knowledge) : route('unggah.pengetahuan.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
    @csrf
    @if(isset($knowledge))
        @method('PUT')
    @endif
    
    <!-- ANCHOR: Form Fields -->
    <div class="form-section">
        <div class="form-group">
            <label for="title" class="form-label">Judul/Nama Pengetahuan</label>
            <input type="text" 
                id="title" 
                name="title" 
                class="form-control @error('title') error @enderror" 
                placeholder="Masukkan judul pengetahuan"
                value="{{ old('title', isset($knowledge) ? $knowledge->title : '') }}"
                required>
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" 
                    name="description" 
                    class="form-control @error('description') error @enderror" 
                    rows="4"
                    placeholder="Masukkan deskripsi pengetahuan"
                    required>{{ old('description', isset($knowledge) ? $knowledge->description : '') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- ANCHOR: Dropdown Fields -->
    <div class="form-section">
        <div class="dropdown-grid">
            <div class="form-group">
                <label for="kkn_type" class="form-label">
                    @if(auth()->user()->role_id == 4)
                        Jenis KKN
                    @else
                        Jenis KKN Pembimbing
                    @endif
                </label>
                <select id="kkn_type" 
                        name="kkn_type" 
                        class="form-control @error('kkn_type') error @enderror"
                        required>
                    <option value="">Pilih Jenis KKN</option>
                    @foreach($jenis_kkn as $jenis)
                        <option value="{{ $jenis['value'] }}" {{ old('kkn_type', isset($knowledge) ? $knowledge->kkn_type : '') == $jenis['value'] ? 'selected' : '' }}>
                            {{ $jenis['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('kkn_type')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kkn_year" class="form-label">
                    @if(auth()->user()->role_id == 4)
                        Tahun KKN
                    @else
                        Tahun KKN Pembimbing
                    @endif
                </label>
                <select id="kkn_year" 
                        name="kkn_year" 
                        class="form-control @error('kkn_year') error @enderror"
                        required>
                    <option value="">Pilih Tahun KKN</option>
                    @foreach($tahun_kkn as $tahun)
                        <option value="{{ $tahun }}" {{ old('kkn_year', isset($knowledge) ? $knowledge->kkn_year : '') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
                @error('kkn_year')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="file_type" class="form-label">Jenis File</label>
                <select id="file_type" 
                        name="file_type" 
                        class="form-control @error('file_type') error @enderror"
                        required>
                    <option value="">Pilih Jenis File</option>
                    @foreach($jenis_file as $jenis)
                        <option value="{{ $jenis['value'] }}" {{ old('file_type', isset($knowledge) ? $knowledge->file_type : '') == $jenis['value'] ? 'selected' : '' }}>
                            {{ $jenis['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('file_type')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Kategori Bidang KKN</label>
                <select id="category_id" 
                        name="category_id" 
                        class="form-control @error('category_id') error @enderror"
                        required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategori_bidang as $kategori)
                        <option value="{{ $kategori['value'] }}" {{ old('category_id', isset($knowledge) ? $knowledge->category_id : '') == $kategori['value'] ? 'selected' : '' }}>
                            {{ $kategori['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if(auth()->user() && auth()->user()->role_id == 4)
            <div class="form-group">
                <label for="kkn_location" class="form-label">Lokasi KKN</label>
                <input type="text" 
                    id="kkn_location" 
                    name="kkn_location" 
                    class="form-control @error('kkn_location') error @enderror" 
                    placeholder="Masukkan lokasi KKN"
                    value="{{ old('kkn_location', isset($knowledge) ? $knowledge->kkn_location : '') }}"
                    required>
                @error('kkn_location')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="group_number" class="form-label">Nomor Kelompok KKN</label>
                <select id="group_number" 
                        name="group_number" 
                        class="form-control @error('group_number') error @enderror"
                        required>
                    <option value="">Pilih nomor kelompok KKN</option>
                    @foreach($nomor_kelompok_kkn as $nomor)
                        <option value="{{ $nomor }}" {{ old('group_number', isset($knowledge) ? $knowledge->group_number : '') == $nomor ? 'selected' : '' }}>Kelompok {{ $nomor }}</option>
                    @endforeach
                </select>
                @error('group_number')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            @endif
        </div>
    </div>

    @if(auth()->user() && auth()->user()->role_id == 5)
    <!-- ANCHOR: Additional Information Section -->
    <div class="form-section">
        <div class="form-group">
            <label for="additional_info" class="form-label">Informasi Tambahan (Opsional)</label>
            <textarea id="additional_info" 
                    name="additional_info" 
                    class="form-control @error('additional_info') error @enderror" 
                    rows="4"
                    placeholder="Masukkan informasi tambahan jika diperlukan">{{ old('additional_info', isset($knowledge) ? $knowledge->additional_info : '') }}</textarea>
            @error('additional_info')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @endif

    <!-- ANCHOR: File Upload Section -->
    <div class="form-section">
        <div class="form-group">
            <label class="form-label">Lampiran File</label>
            <div class="file-upload-container">
                @if(isset($knowledge))
                    <!-- Show existing file in edit mode -->
                    <div class="existing-file-info">
                        <div class="existing-file-content">
                            <div class="file-icon">📄</div>
                            <div class="file-info">
                                <span class="file-name">{{ $knowledge->file_name }}</span>
                                <span class="file-size">{{ $knowledge->file_size_formatted }}</span>
                            </div>
                            <a href="{{ route('unggah.pengetahuan.download', $knowledge) }}" class="btn btn-sm btn-outline-primary" download>
                                Download
                            </a>
                        </div>
                        <div class="file-replace-info">
                            <p class="text-muted">Pilih file baru untuk mengganti file yang ada (opsional)</p>
                        </div>
                    </div>
                @endif
                
                <div class="file-upload-area" id="fileUploadArea" {{ isset($knowledge) ? 'style="display: none;"' : '' }}>
                    <div class="file-upload-content">
                        <div class="file-upload-icon">📁</div>
                        <p class="file-upload-text">{{ isset($knowledge) ? 'Pilih File Baru atau Drag & drop file di sini' : 'Pilih File atau Drag & drop file di sini' }}</p>
                        <button type="button" class="btn btn-primary file-select-btn" onclick="document.getElementById('file').click()">
                            {{ isset($knowledge) ? 'Pilih File Baru' : 'Pilih File' }}
                        </button>
                    </div>
                    <input 
                        type="file" 
                        id="file" 
                        name="file" 
                        class="file-input @error('file') error @enderror"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp4,.avi,.mov"
                        {{ !isset($knowledge) ? 'required' : '' }}>
                </div>
                <div id="filePreview" class="file-preview" style="display: none;">
                    <div class="file-preview-content">
                        <span id="fileName" class="file-name"></span>
                        <button type="button" class="file-remove-btn" onclick="removeFile()">×</button>
                    </div>
                </div>
                @error('file')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    @if(!isset($knowledge))
    <!-- ANCHOR: Declaration Checkbox -->
    <div class="form-section">
        <div class="form-group">
            <div class="checkbox-container">
                <input type="checkbox" 
                    id="declaration" 
                    name="declaration" 
                    class="checkbox-input @error('declaration') error @enderror"
                    required>
                <label for="declaration" class="checkbox-label">
                    Saya menyatakan bahwa pengetahuan yang saya unggah adalah benar dan relevan dengan kegiatan KKN.
                </label>
            </div>
            @error('declaration')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @endif

    <!-- ANCHOR: Form Actions -->
    <div class="form-actions">
        <a href="{{ isset($knowledge) ? route('unggah.pengetahuan') : route('unggah.pengetahuan') }}" class="btn btn-secondary">
            Kembali ke Daftar
        </a>
        <button type="submit" class="btn btn-primary">
            {{ isset($knowledge) ? 'Update' : 'Unggah' }}
        </button>
    </div>
</form>

<script>
// ANCHOR: File Upload Handling
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;
            fileUploadArea.style.display = 'none';
            filePreview.style.display = 'block';
            
            // Hide existing file info if in edit mode
            const existingFileInfo = document.querySelector('.existing-file-info');
            if (existingFileInfo) {
                existingFileInfo.style.display = 'none';
            }
        }
    });

    // Handle drag and drop
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUploadArea.classList.add('drag-over');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('drag-over');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileName.textContent = files[0].name;
            fileUploadArea.style.display = 'none';
            filePreview.style.display = 'block';
        }
    });
});

// ANCHOR: Remove File Function
function removeFile() {
    document.getElementById('file').value = '';
    document.getElementById('fileUploadArea').style.display = 'block';
    document.getElementById('filePreview').style.display = 'none';
    
    // Show existing file info if in edit mode
    const existingFileInfo = document.querySelector('.existing-file-info');
    if (existingFileInfo) {
        existingFileInfo.style.display = 'block';
    }
}
</script>

<style>
/* ANCHOR: Existing File Styles */
.existing-file-info {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.existing-file-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-icon {
    font-size: 2rem;
}

.file-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.file-info .file-name {
    font-weight: 500;
    color: #495057;
}

.file-info .file-size {
    font-size: 0.875rem;
    color: #6c757d;
}

.file-replace-info {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

.file-replace-info p {
    margin: 0;
    font-size: 0.875rem;
}

.text-muted {
    color: #6c757d !important;
}
</style>
@endsection 