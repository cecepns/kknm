@extends('layouts.dashboard')

@section('title', $pageType === 'validation' ? 'Validasi Pengetahuan - KMS KKN' : ($pageType === 'user' ? 'Daftar Pengetahuan Saya - KMS KKN' : 'Verifikasi Pengetahuan - KMS KKN'))

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">
            @if($pageType === 'validation')
                Validasi Pengetahuan
            @elseif($pageType === 'user')
                Daftar Pengetahuan Saya
            @else
                Verifikasi Pengetahuan
            @endif
        </h1>
    </div>
    @if($pageType === 'user')
        <a href="{{ route('unggah.pengetahuan.create') }}" class="btn btn-primary">
            Unggah Pengetahuan Baru
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

    @if($pageType === 'user' ? $userKnowledge->count() > 0 : ($pageType === 'validation' ? $verifiedKnowledge->count() > 0 : $pendingKnowledge->count() > 0))
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul Pengetahuan</th>
                        <th>Jenis File</th>
                        <th>Kategori</th>
                        @if($pageType !== 'user')
                            <th>Pengunggah</th>
                        @endif
                    
                        <th>{{ $pageType === 'validation' ? 'Tanggal Verifikasi' : 'Tanggal Unggah' }}</th>
                        
                        @if($pageType === 'user')
                            <th>Status</th>
                        @endif
                        
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pageType === 'user' ? $userKnowledge : ($pageType === 'validation' ? $verifiedKnowledge : $pendingKnowledge) as $knowledge)
                        <tr>
                            <td class="knowledge-title">{{ $knowledge->title }}</td>
                            <td class="file-type">
                                {{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }}
                            </td>
                            <td class="category">
                                    {{ \App\Helpers\UniversityDataHelper::getKategoriBidangLabel($knowledge->field_category) }}
                            </td>
                            @if($pageType !== 'user')
                                <td class="uploader">
                                    {{ $knowledge->user->name }}
                                </td>
                            @endif
                            <td class="upload-date">
                                @if($pageType === 'validation')
                                    {{ $knowledge->approved_at ? $knowledge->approved_at->format('Y-m-d') : '-' }}
                                @else
                                    {{ $knowledge->created_at->format('Y-m-d') }}
                                @endif
                            </td>
                            @if($pageType === 'user')
                                <td class="status">
                                    @switch($knowledge->status)
                                        @case('pending')
                                            <span >Menunggu Review</span>
                                            @break
                                        @case('verified')
                                            <span>Terverifikasi</span>
                                            @break
                                        @case('validated')
                                            <span>Tervalidasi</span>
                                            @break
                                        @case('rejected')
                                            <span>Ditolak</span>
                                            @break
                                        @default
                                            <span class="status-badge">{{ ucfirst($knowledge->status) }}</span>
                                    @endswitch
                                </td>
                            @endif
                            <td class="action">
                                <a 
                                    href="{{ $pageType === 'validation' ? route('validasi.pengetahuan.detail', $knowledge) : ($pageType === 'user' ? route('unggah.pengetahuan.detail', $knowledge) : route('verifikasi.pengetahuan.detail', $knowledge)) }}" 
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
            <h3 class="empty-state-title">
                @if($pageType === 'user')
                    Belum Ada Pengetahuan
                @else
                    Tidak Ada Data {{ $pageType === 'validation' ? 'Validasi' : 'Verifikasi' }}
                @endif
            </h3>
            <p class="empty-state-description">
                @if($pageType === 'user')
                    Anda belum mengunggah pengetahuan apapun. Mulai unggah pengetahuan pertama Anda!
                @else
                    Saat ini tidak ada pengetahuan yang menunggu {{ $pageType === 'validation' ? 'validasi' : 'verifikasi' }}.
                @endif
            </p>
            @if($pageType === 'user')
                <a href="{{ route('unggah.pengetahuan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Unggah Pengetahuan Pertama
                </a>
            @endif
        </div>
    @endif
@endsection 