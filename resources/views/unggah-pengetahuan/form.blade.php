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
                <label for="judul" class="form-label">Judul/Nama Pengetahuan</label>
                <input type="text" 
                       id="judul" 
                       name="judul" 
                       class="form-control @error('judul') error @enderror" 
                       placeholder="Masukkan judul pengetahuan"
                       value="{{ old('judul') }}"
                       required>
                @error('judul')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" 
                          name="deskripsi" 
                          class="form-control @error('deskripsi') error @enderror" 
                          rows="4"
                          placeholder="Masukkan deskripsi pengetahuan"
                          required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- ANCHOR: Dropdown Fields -->
        <div class="form-section">
            <div class="dropdown-grid">
                <div class="form-group">
                    <label for="jenis_kkn" class="form-label">
                        @if(auth()->user()->role_id == 4)
                            Jenis KKN
                        @else
                            Jenis KKN Pembimbing
                        @endif
                    </label>
                    <select id="jenis_kkn" 
                            name="jenis_kkn" 
                            class="form-control @error('jenis_kkn') error @enderror"
                            required>
                        <option value="">Pilih Jenis KKN</option>
                        <option value="reguler" {{ old('jenis_kkn') == 'reguler' ? 'selected' : '' }}>KKN Reguler</option>
                        <option value="tematik" {{ old('jenis_kkn') == 'tematik' ? 'selected' : '' }}>KKN Tematik</option>
                        <option value="internasional" {{ old('jenis_kkn') == 'internasional' ? 'selected' : '' }}>KKN Internasional</option>
                    </select>
                    @error('jenis_kkn')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tahun_kkn" class="form-label">
                        @if(auth()->user()->role_id == 4)
                            Tahun KKN
                        @else
                            Tahun KKN Pembimbing
                        @endif
                    </label>
                    <select id="tahun_kkn" 
                            name="tahun_kkn" 
                            class="form-control @error('tahun_kkn') error @enderror"
                            required>
                        <option value="">Pilih Tahun KKN</option>
                        @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}" {{ old('tahun_kkn') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    @error('tahun_kkn')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_file" class="form-label">Jenis File</label>
                    <select id="jenis_file" 
                            name="jenis_file" 
                            class="form-control @error('jenis_file') error @enderror"
                            required>
                        <option value="">Pilih Jenis File</option>
                        <option value="dokumen" {{ old('jenis_file') == 'dokumen' ? 'selected' : '' }}>Dokumen</option>
                        <option value="presentasi" {{ old('jenis_file') == 'presentasi' ? 'selected' : '' }}>Presentasi</option>
                        <option value="video" {{ old('jenis_file') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="gambar" {{ old('jenis_file') == 'gambar' ? 'selected' : '' }}>Gambar</option>
                        <option value="lainnya" {{ old('jenis_file') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_file')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori_bidang" class="form-label">Kategori Bidang KKN</label>
                    <select id="kategori_bidang" 
                            name="kategori_bidang" 
                            class="form-control @error('kategori_bidang') error @enderror"
                            required>
                        <option value="">Pilih kategori</option>
                        <option value="pendidikan" {{ old('kategori_bidang') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="kesehatan" {{ old('kategori_bidang') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="ekonomi" {{ old('kategori_bidang') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                        <option value="lingkungan" {{ old('kategori_bidang') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                        <option value="teknologi" {{ old('kategori_bidang') == 'teknologi' ? 'selected' : '' }}>Teknologi</option>
                        <option value="sosial" {{ old('kategori_bidang') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                    </select>
                    @error('kategori_bidang')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi_kkn" class="form-label">Lokasi KKN</label>
                    <input type="text" 
                           id="lokasi_kkn" 
                           name="lokasi_kkn" 
                           class="form-control @error('lokasi_kkn') error @enderror" 
                           placeholder="Masukkan lokasi KKN"
                           value="{{ old('lokasi_kkn') }}"
                           required>
                    @error('lokasi_kkn')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_kelompok" class="form-label">Nomor Kelompok KKN</label>
                    <select id="nomor_kelompok" 
                            name="nomor_kelompok" 
                            class="form-control @error('nomor_kelompok') error @enderror"
                            required>
                        <option value="">Pilih nomor kelompok KKN</option>
                        @for($i = 1; $i <= 50; $i++)
                            <option value="{{ $i }}" {{ old('nomor_kelompok') == $i ? 'selected' : '' }}>Kelompok {{ $i }}</option>
                        @endfor
                    </select>
                    @error('nomor_kelompok')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @if(auth()->user() && auth()->user()->role_id == 5)
        <!-- ANCHOR: Additional Information Section -->
        <div class="form-section">
            <div class="form-group">
                <label for="informasi_tambahan" class="form-label">Informasi Tambahan (Opsional)</label>
                <textarea id="informasi_tambahan" 
                          name="informasi_tambahan" 
                          class="form-control @error('informasi_tambahan') error @enderror" 
                          rows="4"
                          placeholder="Masukkan informasi tambahan jika diperlukan">{{ old('informasi_tambahan') }}</textarea>
                @error('informasi_tambahan')
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
                        <input type="file" 
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