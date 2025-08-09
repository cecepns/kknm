@extends('layouts.dashboard')

@section('title', $pageType === 'validation' ? 'Detail Validasi Pengetahuan - KMS KKN' : ($pageType === 'user' ? 'Detail Pengetahuan Saya - KMS KKN' : ($pageType === 'public' ? 'Detail Pengetahuan - KMS KKN' : 'Detail Verifikasi Pengetahuan - KMS KKN')))

@section('content')
<div class="page-header">
    @if ($pageType === 'validation')
        <h1 class="page-title">Detail Validasi Pengetahuan</h1>
        <a href="{{ route('validasi.pengetahuan') }}" class="btn btn-secondary">
            Kembali
        </a>
    @elseif ($pageType === 'user')
        <h1 class="page-title">Detail Pengetahuan Saya</h1>
        <a href="{{ route('unggah.pengetahuan') }}" class="btn btn-secondary">
            Kembali
        </a>
    @elseif ($pageType === 'public')
        <h1 class="page-title">Detail Pengetahuan</h1>
        <a href="{{ route('repositori.publik') }}" class="btn btn-secondary">
            Kembali ke Repositori
        </a>
    @elseif ($pageType === 'repository')
        <h1 class="page-title">Detail Pengetahuan</h1>
        <a href="{{ route('kelola.repositori') }}" class="btn btn-secondary">
            Kembali ke Kelola Repositori
        </a>
    @else
        <h1 class="page-title">Detail Verifikasi Pengetahuan</h1>
        <a href="{{ route('verifikasi.pengetahuan') }}" class="btn btn-secondary">
            Kembali
        </a>
    @endif
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

<div class="detail-header">
    <h3 class="detail-title">{{ $knowledge->title }}</h3>
    @if($pageType !== 'public')
        <span class="status-badge status-{{ $knowledge->status }}">
            @switch($knowledge->status)
                @case('pending')
                    Menunggu Verifikasi
                    @break
                @case('verified')
                    Menunggu Validasi
                    @break
                @case('rejected')
                    Pengetahuan di Tolak
                    @break
                @default
                    {{ ucfirst($knowledge->status) }}
            @endswitch
        </span>
    @else
        <span class="status-badge status-validated">
            Tervalidasi
        </span>
    @endif
</div>

<div class="detail-content">
    <div class="detail-metadata"> 
        <div class="detail-metadata-item">
            <h5 class="label">Jenis File</h5>
            <p class="value">{{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }}</p>
        </div>
        <div class="detail-metadata-item">
            <h5 class="label">Kategori</h5>
            <p class="value">{{ $knowledge->category ? $knowledge->category->name : \App\Helpers\UniversityDataHelper::getKnowledgeCategoryLabel($knowledge->category_id) }}</p>
        </div>
        <div class="detail-metadata-item">
            <h5 class="label">Tanggal Unggah</h5>
            <p class="value">{{ $knowledge->created_at->format('d F Y H:i') }}</p>
        </div>
        @if($pageType === 'public')
            <div class="detail-metadata-item">
                <h5 class="label">Pengunggah</h5>
                <p class="value">{{ $knowledge->user->name }}</p>
            </div>
            <div class="detail-metadata-item">
                <h5 class="label">Kelompok KKN</h5>
                <p class="value">Kelompok {{ $knowledge->group_number }}</p>
            </div>
            <div class="detail-metadata-item">
                <h5 class="label">Lokasi KKN</h5>
                <p class="value">{{ $knowledge->kkn_location }}</p>
            </div>
            <div class="detail-metadata-item">
                <h5 class="label">Tahun KKN</h5>
                <p class="value">{{ $knowledge->kkn_year }}</p>
            </div>
            <div class="detail-metadata-item">
                <h5 class="label">Jenis KKN</h5>
                <p class="value">{{ \App\Helpers\UniversityDataHelper::getJenisKKNLabel($knowledge->kkn_type) }}</p>
            </div>
        @else
            @if (auth()->user()->role_id !== 4 && auth()->user()->role_id !== 5)
                <div class="detail-metadata-item">
                    <h5 class="label">Pengunggah</h5>
                    <p class="value">{{ $knowledge->user->name }}</p>
                </div>
            @endif
            @if(auth()->user()->role_id == 4)
                <div class="detail-metadata-item">
                    <h5 class="label">Kelompok KKN</h5>
                    <p class="value">Kelompok {{ $knowledge->group_number }}</p>
                </div>
                <div class="detail-metadata-item">
                    <h5 class="label">Lokasi KKN</h5>
                    <p class="value">{{ $knowledge->kkn_location }}</p>
                </div>
            @endif
            @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 5)
            <div class="detail-metadata-item">
                <h5 class="label">Tahun KKN</h5>
                <p class="value">{{ $knowledge->kkn_year }}</p>
            </div>
            @endif
        @endif
    </div>
    <div>
        <div class="detail-description">
            <h5 class="label">Deskripsi</h5>
            <p class="value">{{ $knowledge->description }}</p>
        </div>
        @if(auth()->user()->role_id == 5 || $pageType === 'public')
        <div class="detail-description">
            <h5 class="label">Informasi Tambahan</h5>
            <p class="value">{{ $knowledge->additional_info ?: '-' }}</p>
        </div>
        @endif
    </div>
</div>  

<div class="preview-file">
    <div class="preview-file-header">
        <h5 class="label">Preview File</h5>
        @if($pageType === 'public')
            <a href="{{ route('repositori.publik.download', $knowledge) }}" class="btn btn-primary" download>
                Unduh File
            </a>
        @else
            <a href="{{ asset('storage/'.$knowledge->file_path) }}" class="btn btn-primary" download>
                Unduh File
            </a>
        @endif
    </div>
    <div class="preview-file-content">
            @php
                $ext = strtolower(pathinfo($knowledge->file_name ?? $knowledge->file_path, PATHINFO_EXTENSION));
            @endphp
            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <img src="{{ asset('storage/'.$knowledge->file_path) }}" alt="Preview File">
            @elseif($ext === 'pdf')
                <iframe
                    src="{{ asset('storage/'.$knowledge->file_path) }}"
                    width="100%"
                    height="800px"
                    title="Preview PDF"
                ></iframe>
            @elseif(in_array($ext, ['mp4', 'webm', 'ogg']))
                <video width="100%" height="auto" controls>
                    <source src="{{ asset('storage/'.$knowledge->file_path) }}" type="video/{{ $ext }}">
                    Browser Anda tidak mendukung tag video.
                </video>
            @else
                <div class="file-preview-placeholder">
                    <i class="fas fa-file-alt"></i>
                    <p>Preview tidak tersedia untuk jenis file ini</p>
                    <p class="file-name">{{ $knowledge->file_name ?? basename($knowledge->file_path) }}</p>
                </div>
            @endif
    </div>
</div>

@if($pageType === 'repository')
<div class="detail-action">
    <form action="{{ route('kelola.repositori.destroy', $knowledge) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengetahuan ini?')">
            Delete
        </button>
    </form>
</div>
@elseif($pageType === 'user')
<div class="detail-action">
    @if(in_array($knowledge->status, ['pending', 'rejected']))
        <div class="action-info">
            <p class="action-info-text">
                @if($knowledge->status === 'pending')
                    Pengetahuan ini masih menunggu review. Anda dapat mengedit atau menghapusnya.
                @else
                    Pengetahuan ini ditolak. Anda dapat mengedit dan mengirim ulang atau menghapusnya.
                @endif
            </p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('unggah.pengetahuan.edit', $knowledge) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Pengetahuan
            </a>
            <form action="{{ route('unggah.pengetahuan.destroy', $knowledge) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirmDelete('{{ $knowledge->title }}')">
                    <i class="fas fa-trash"></i> Hapus Pengetahuan
                </button>
            </form>
        </div>
    @else
        <div class="action-info">
            <p class="action-info-text">
                @if($knowledge->status === 'verified')
                    Pengetahuan ini sudah diverifikasi dan sedang menunggu validasi akhir.
                @elseif($knowledge->status === 'validated')
                    Pengetahuan ini sudah tervalidasi dan tersedia di repositori publik.
                @else
                    Pengetahuan ini sedang dalam proses review.
                @endif
            </p>
        </div>
    @endif
</div>
@elseif(($pageType ?? null) !== 'public' && (auth()->user()->role_id == 1 || auth()->user()->role_id == 2))
<div class="detail-action">
    @if(auth()->user()->role_id == 2)
    <form action="{{ route('verifikasi.pengetahuan.reject', $knowledge) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">
            Tolak
        </button>
    </form>
    <form action="{{ route('verifikasi.pengetahuan.approve', $knowledge) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success">
            Verifikasi
        </button>
    </form>
    @elseif(auth()->user()->role_id == 1)
    <form action="{{ route('validasi.pengetahuan.reject', $knowledge) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">
            Tolak
        </button>
    </form>
    <form action="{{ route('validasi.pengetahuan.validate', $knowledge) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success">
            Validasi
        </button>
    </form>
    @endif 
</div>
@endif

<style>
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.6rem;
        margin-top: 3rem;
    }

    .detail-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.6rem;
    }

    .detail-metadata {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.6rem;
    }

    .preview-file {
        margin-top: 1.6rem;
    }

    .preview-file-header {
        margin-bottom: 1.6rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-file-header h5 {
        margin-bottom: 0;
    }

    .preview-file-content {
        width: 100%;
        
    }

    .preview-file-content img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-file-content iframe {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
    }

    .file-preview-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        text-align: center;
    }

    .file-preview-placeholder i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .file-preview-placeholder p {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .status-validated {
        background-color: #28a745;
        color: white;
    }

    .detail-action {
        display: flex;
        flex-direction: column;
        margin-top: 1.6rem;
        gap: 1rem;
    }

    .action-info {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .action-info-text {
        margin: 0;
        color: #6c757d;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
    }

</style>

@if($pageType === 'user')
<script>
// ANCHOR: Confirm delete functionality
function confirmDelete(title) {
    return confirm(`Apakah Anda yakin ingin menghapus pengetahuan "${title}"?\n\nTindakan ini tidak dapat dibatalkan.`);
}
</script>
@endif
@endsection 