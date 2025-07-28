@extends('layouts.dashboard')

@section('title', $pageType === 'validation' ? 'Validasi Pengetahuan - KMS KKN' : ($pageType === 'user' ? 'Daftar Pengetahuan Saya - KMS KKN' : ($pageType === 'repository' ? 'Kelola Repositori - KMS KKN' : 'Verifikasi Pengetahuan - KMS KKN')))

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">
            @if($pageType === 'validation')
                Validasi Pengetahuan
            @elseif($pageType === 'user')
                Daftar Pengetahuan Saya
            @elseif($pageType === 'repository')
                Kelola Repositori
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

    @if($pageType === 'user' ? $userKnowledge->count() > 0 : ($pageType === 'validation' ? $verifiedKnowledge->count() > 0 : ($pageType === 'repository' ? $allKnowledge->count() > 0 : $pendingKnowledge->count() > 0)))
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
                    @foreach($pageType === 'user' ? $userKnowledge : ($pageType === 'validation' ? $verifiedKnowledge : ($pageType === 'repository' ? $allKnowledge : $pendingKnowledge)) as $knowledge)
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
                                            <span class="status-badge status-pending">Menunggu Review</span>
                                            @break
                                        @case('verified')
                                            <span class="status-badge status-verified">Terverifikasi</span>
                                            @break
                                        @case('validated')
                                            <span class="status-badge status-validated">Tervalidasi</span>
                                            @break
                                        @case('rejected')
                                            <span class="status-badge status-rejected">Ditolak</span>
                                            @break
                                        @default
                                            <span class="status-badge">{{ ucfirst($knowledge->status) }}</span>
                                    @endswitch
                                </td>
                            @endif
                            

                            <td class="action">
                                @if($pageType === 'repository')
                                    <a 
                                        href="{{ route('kelola.repositori.detail', $knowledge) }}" 
                                        class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
                                    <form action="{{ route('kelola.repositori.destroy', $knowledge) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengetahuan ini?')">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <a 
                                        href="{{ $pageType === 'validation' ? route('validasi.pengetahuan.detail', $knowledge) : ($pageType === 'user' ? route('unggah.pengetahuan.detail', $knowledge) : route('verifikasi.pengetahuan.detail', $knowledge)) }}" 
                                        class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
                                @endif
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
                @elseif($pageType === 'repository')
                    Tidak Ada Data Repositori
                @else
                    Tidak Ada Data {{ $pageType === 'validation' ? 'Validasi' : 'Verifikasi' }}
                @endif
            </h3>
            <p class="empty-state-description">
                @if($pageType === 'user')
                    Anda belum mengunggah pengetahuan apapun. Mulai unggah pengetahuan pertama Anda!
                @elseif($pageType === 'repository')
                    Saat ini tidak ada pengetahuan yang sudah divalidasi dalam repositori.
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

<style>
/* ANCHOR: Status Badge Styles */
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending {
    background-color: #ffc107;
    color: #212529;
}

.status-verified {
    background-color: #17a2b8;
    color: white;
}

.status-validated {
    background-color: #28a745;
    color: white;
}

.status-rejected {
    background-color: #dc3545;
    color: white;
}
</style> 