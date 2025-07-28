@extends('layouts.dashboard')

@section('title', $pageType === 'validation' ? 'Detail Validasi Pengetahuan - KMS KKN' : 'Detail Verifikasi Pengetahuan - KMS KKN')

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
</div>

<div class="detail-content">
    <div class="detail-metadata"> 
        <div class="detail-metadata-item">
            <h5 class="label">Jenis File</h5>
            <p class="value">{{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }}</p>
        </div>
        <div class="detail-metadata-item">
            <h5 class="label">Kategori</h5>
            <p class="value">{{ \App\Helpers\UniversityDataHelper::getKategoriBidangLabel($knowledge->field_category) }}</p>
        </div>
        <div class="detail-metadata-item">
            <h5 class="label">Tanggal Unggah</h5>
            <p class="value">{{ $knowledge->created_at->format('d F Y H:i') }}</p>
        </div>
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
    </div>
    <div>
        <div class="detail-description">
            <h5 class="label">Deskripsi</h5>
            <p class="value">{{ $knowledge->description }}</p>
        </div>
        @if(auth()->user()->role_id == 5)
        <div class="detail-description">
            <h5 class="label">Informasi Tambahan</h5>
            <p class="value">{{ $knowledge->additional_info }}</p>
        </div>
        @endif
    </div>
</div>  

<div class="preview-file">
    <div class="preview-file-header">
        <h5 class="label">Preview File</h5>
        <a href="{{ asset('storage/'.$knowledge->file_path) }}" class="btn btn-primary" download>
            Unduh File
        </a>
    </div>
    <div class="preview-file-content">
        <img src="{{ asset('storage/'.$knowledge->file_path) }}" alt="Preview File">
    </div>
</div>

@if(auth()->user()->role_id != 4 && auth()->user()->role_id != 5)
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

    .detail-action {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 1.6rem;
        gap: 1.6rem;
    }

</style>
@endsection 