@extends('layouts.dashboard')

@section('title', $pageType === 'validation' ? 'Validasi Pengetahuan - KMS KKN' : 'Verifikasi Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $pageType === 'validation' ? 'Validasi Pengetahuan' : 'Verifikasi Pengetahuan' }}</h1>
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

<div class="verification-container">
    @if(($pageType === 'validation' ? $verifiedKnowledge : $pendingKnowledge)->count() > 0)
        <div class="table-container">
            <table class="verification-table">
                <thead>
                    <tr>
                        <th>Judul Pengetahuan</th>
                        <th>Jenis File</th>
                        <th>Kategori</th>
                        <th>Pengunggah</th>
                        <th>{{ $pageType === 'validation' ? 'Tanggal Verifikasi' : 'Tanggal Unggah' }}</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pageType === 'validation' ? $verifiedKnowledge : $pendingKnowledge as $knowledge)
                        <tr>
                            <td class="knowledge-title">{{ $knowledge->title }}</td>
                            <td class="file-type">
                                <a href="#" class="link-primary">
                                    {{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }}
                                </a>
                            </td>
                            <td class="category">
                                <a href="#" class="link-primary">
                                    {{ \App\Helpers\UniversityDataHelper::getKategoriBidangLabel($knowledge->field_category) }}
                                </a>
                            </td>
                            <td class="uploader">
                                <a href="#" class="link-primary">
                                    {{ $knowledge->user->name }}
                                </a>
                            </td>
                            <td class="upload-date">
                                @if($pageType === 'validation')
                                    {{ $knowledge->approved_at ? $knowledge->approved_at->format('Y-m-d') : '-' }}
                                @else
                                    {{ $knowledge->created_at->format('Y-m-d') }}
                                @endif
                            </td>
                            <td class="action">
                                <a href="{{ $pageType === 'validation' ? route('validasi.pengetahuan.detail', $knowledge) : route('verifikasi.pengetahuan.detail', $knowledge) }}" 
                                   class="btn btn-primary btn-sm">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3 class="empty-state-title">Tidak Ada Data {{ $pageType === 'validation' ? 'Validasi' : 'Verifikasi' }}</h3>
            <p class="empty-state-description">
                Saat ini tidak ada pengetahuan yang menunggu {{ $pageType === 'validation' ? 'validasi' : 'verifikasi' }}.
            </p>
        </div>
    @endif
</div>

<style>
.verification-container {
    background: white;
    border-radius: 8px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table-container {
    overflow-x: auto;
}

.verification-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
}

.verification-table th {
    background-color: #f8f9fa;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.verification-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.verification-table tbody tr:hover {
    background-color: #f8f9fa;
}

.knowledge-title {
    font-weight: 500;
    color: #212529;
}

.link-primary {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.link-primary:hover {
    text-decoration: underline;
}

.upload-date {
    color: #6c757d;
    font-size: 0.9em;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.875em;
    display: inline-block;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    text-decoration: none;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #495057;
}

.empty-state-description {
    font-size: 0.9rem;
    margin: 0;
}
</style>
@endsection 