@extends('layouts.dashboard')

@section('title', 'Unggah Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <h1 class="page-title">Unggah Pengetahuan</h1>
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

<div class="upload-form-container">
    <form action="{{ route('unggah.pengetahuan.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf
        
        <!-- ANCHOR: Form Fields -->
        <div class="form-section">
            <div class="form-group">
                <label for="title" class="form-label">Judul/Nama Pengetahuan</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       class="form-control @error('title') error @enderror" 
                       placeholder="Masukkan judul pengetahuan"
                       value="{{ old('title') }}"
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
                          required>{{ old('description') }}</textarea>
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
                            <option value="{{ $jenis['value'] }}" {{ old('kkn_type') == $jenis['value'] ? 'selected' : '' }}>
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
                            <option value="{{ $tahun }}" {{ old('kkn_year') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
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
                            <option value="{{ $jenis['value'] }}" {{ old('file_type') == $jenis['value'] ? 'selected' : '' }}>
                                {{ $jenis['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('file_type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="field_category" class="form-label">Kategori Bidang KKN</label>
                    <select id="field_category" 
                            name="field_category" 
                            class="form-control @error('field_category') error @enderror"
                            required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategori_bidang as $kategori)
                            <option value="{{ $kategori['value'] }}" {{ old('field_category') == $kategori['value'] ? 'selected' : '' }}>
                                {{ $kategori['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('field_category')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kkn_location" class="form-label">Lokasi KKN</label>
                    <input type="text" 
                           id="kkn_location" 
                           name="kkn_location" 
                           class="form-control @error('kkn_location') error @enderror" 
                           placeholder="Masukkan lokasi KKN"
                           value="{{ old('kkn_location') }}"
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
                            <option value="{{ $nomor }}" {{ old('group_number') == $nomor ? 'selected' : '' }}>Kelompok {{ $nomor }}</option>
                        @endforeach
                    </select>
                    @error('group_number')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
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
                          placeholder="Masukkan informasi tambahan jika diperlukan">{{ old('additional_info') }}</textarea>
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
                    <div class="file-upload-area" id="fileUploadArea">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">📁</div>
                            <p class="file-upload-text">Pilih File atau Drag & drop file di sini</p>
                            <button type="button" class="btn btn-primary file-select-btn" onclick="document.getElementById('file').click()">
                                Pilih File
                            </button>
                        </div>
                        <input 
                            type="file" 
                            id="file" 
                            name="file" 
                            class="file-input @error('file') error @enderror"
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp4,.avi,.mov"
                            required>
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

        <!-- ANCHOR: Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="history.back()">
                Batal
            </button>
            <button type="submit" class="btn btn-primary">
                Unggah
            </button>
        </div>
    </form>
</div>

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
}
</script>
@endsection 