@extends('layouts.dashboard')

@section('title', 'Detail Verifikasi Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">Detail Verifikasi Pengetahuan</h1>
        <a href="{{ route('verifikasi.pengetahuan') }}" class="btn btn-secondary">
            ← Kembali ke Daftar
        </a>
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

<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <h2 class="detail-title">{{ $knowledge->judul }}</h2>
            <span class="status-badge status-pending">Menunggu Review</span>
        </div>

        <div class="detail-content">
            <!-- ANCHOR: Basic Information -->
            <div class="info-section">
                <h3 class="section-title">Informasi Dasar</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Deskripsi:</label>
                        <p class="info-value">{{ $knowledge->deskripsi }}</p>
                    </div>
                    
                    @if($knowledge->informasi_tambahan)
                    <div class="info-item">
                        <label class="info-label">Informasi Tambahan:</label>
                        <p class="info-value">{{ $knowledge->informasi_tambahan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ANCHOR: KKN Information -->
            <div class="info-section">
                <h3 class="section-title">Informasi KKN</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Jenis KKN:</label>
                        <span class="info-value">{{ \App\Helpers\UniversityDataHelper::getJenisKKNLabel($knowledge->jenis_kkn) }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Tahun KKN:</label>
                        <span class="info-value">{{ $knowledge->tahun_kkn }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Lokasi KKN:</label>
                        <span class="info-value">{{ $knowledge->lokasi_kkn }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Nomor Kelompok:</label>
                        <span class="info-value">{{ $knowledge->nomor_kelompok }}</span>
                    </div>
                </div>
            </div>

            <!-- ANCHOR: File Information -->
            <div class="info-section">
                <h3 class="section-title">Informasi File</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Jenis File:</label>
                        <span class="info-value">{{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->jenis_file) }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Kategori Bidang:</label>
                        <span class="info-value">{{ \App\Helpers\UniversityDataHelper::getKategoriBidangLabel($knowledge->kategori_bidang) }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Nama File:</label>
                        <span class="info-value">{{ $knowledge->nama_file }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Ukuran File:</label>
                        <span class="info-value">{{ $knowledge->file_size_formatted }}</span>
                    </div>
                </div>
                
                <div class="file-download">
                    <a href="{{ route('unggah.pengetahuan.download', $knowledge) }}" 
                       class="btn btn-primary">
                        📥 Download File
                    </a>
                </div>
            </div>

            <!-- ANCHOR: Uploader Information -->
            <div class="info-section">
                <h3 class="section-title">Informasi Pengunggah</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label class="info-label">Nama:</label>
                        <span class="info-value">{{ $knowledge->user->name }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Email:</label>
                        <span class="info-value">{{ $knowledge->user->email }}</span>
                    </div>
                    <div class="info-item">
                        <label class="info-label">Tanggal Unggah:</label>
                        <span class="info-value">{{ $knowledge->created_at->format('d F Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANCHOR: Verification Actions -->
        <div class="verification-actions">            
            <div class="action-buttons">
                <form action="{{ route('verifikasi.pengetahuan.approve', $knowledge) }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        ✅ Setujui
                    </button>
                </form>

                <form action="{{ route('verifikasi.pengetahuan.reject', $knowledge) }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        ❌ Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.875em;
}

.btn-secondary:hover {
    background-color: #545b62;
    border-color: #545b62;
    text-decoration: none;
    color: white;
}

.detail-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.detail-header {
    padding: 24px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #212529;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875em;
    font-weight: 500;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.detail-content {
    padding: 24px;
}

.info-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e9ecef;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 16px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.875em;
}

.info-value {
    color: #212529;
    margin: 0;
    line-height: 1.5;
}

.file-download {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e9ecef;
}

.verification-actions {
    padding: 32px;
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 8px 8px;
}

.action-buttons {
    display: flex;
    gap: 16px;
    margin-top: 20px;
}

.inline-form {
    margin: 0;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
    padding: 12px 24px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.2s ease;
    min-width: 120px;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    padding: 12px 24px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.2s ease;
    min-width: 120px;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
</style>
@endsection 