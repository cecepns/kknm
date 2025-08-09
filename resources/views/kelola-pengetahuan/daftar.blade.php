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
    @elseif($pageType === 'verification')
        <div class="batch-actions" id="batch-actions" style="display: none;">
            <form id="batch-form" method="POST" style="display: inline;">
                @csrf
                <button type="button" class="btn btn-success" onclick="submitBatchAction('approve')">
                    Verifikasi Terpilih
                </button>
                <button type="button" class="btn btn-danger" onclick="submitBatchAction('reject')">
                    Tolak Terpilih
                </button>
                <span class="selected-count" id="selected-count">0 item dipilih</span>
            </form>
        </div>
    @elseif($pageType === 'validation')
        <div class="batch-actions" id="batch-actions" style="display: none;">
            <form id="batch-form" method="POST" style="display: inline;">
                @csrf
                <button type="button" class="btn btn-success" onclick="submitBatchAction('validate')">
                    Validasi Terpilih
                </button>
                <button type="button" class="btn btn-danger" onclick="submitBatchAction('reject')">
                    Tolak Terpilih
                </button>
                <span class="selected-count" id="selected-count">0 item dipilih</span>
            </form>
        </div>
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
                        @if($pageType === 'verification' || $pageType === 'validation')
                            <th style="width: 40px;">
                                <input type="checkbox" id="select-all" onchange="toggleAllCheckboxes()">
                            </th>
                        @endif
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
                            @if($pageType === 'verification' || $pageType === 'validation')
                                <td>
                                    <input type="checkbox" class="knowledge-checkbox" value="{{ $knowledge->id }}" onchange="updateBatchActions()">
                                </td>
                            @endif
                            <td class="knowledge-title">{{ $knowledge->title }}</td>
                            <td class="file-type">
                                {{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }}
                            </td>
                            <td class="category">
                                    {{ $knowledge->category ? $knowledge->category->name : \App\Helpers\UniversityDataHelper::getKnowledgeCategoryLabel($knowledge->category_id) }}
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

/* ANCHOR: Batch Actions Styles */
.batch-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
}

.selected-count {
    font-size: 0.875rem;
    color: #6c757d;
    margin-left: 1rem;
}

.knowledge-checkbox {
    margin: 0;
}

#select-all {
    margin: 0;
}
</style>

@if($pageType === 'verification' || $pageType === 'validation')
<script>
// ANCHOR: Handle checkbox selection functionality
function toggleAllCheckboxes() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.knowledge-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBatchActions();
}

function updateBatchActions() {
    const checkboxes = document.querySelectorAll('.knowledge-checkbox:checked');
    const batchActions = document.getElementById('batch-actions');
    const selectedCount = document.getElementById('selected-count');
    const selectAll = document.getElementById('select-all');
    
    // Update selected count
    selectedCount.textContent = `${checkboxes.length} item dipilih`;
    
    // Show/hide batch actions
    if (checkboxes.length > 0) {
        batchActions.style.display = 'block';
    } else {
        batchActions.style.display = 'none';
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.knowledge-checkbox');
    if (checkboxes.length === allCheckboxes.length) {
        selectAll.checked = true;
        selectAll.indeterminate = false;
    } else if (checkboxes.length > 0) {
        selectAll.checked = false;
        selectAll.indeterminate = true;
    } else {
        selectAll.checked = false;
        selectAll.indeterminate = false;
    }
}

function submitBatchAction(action) {
    const checkboxes = document.querySelectorAll('.knowledge-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Pilih minimal satu pengetahuan untuk diproses.');
        return;
    }
    
    let actionText, confirmMessage;
    
    // Determine action text based on page type and action
    @if($pageType === 'verification')
        actionText = action === 'approve' ? 'memverifikasi' : 'menolak';
    @else
        actionText = action === 'validate' ? 'memvalidasi' : 'menolak';
    @endif
    
    confirmMessage = `Apakah Anda yakin ingin ${actionText} ${checkboxes.length} pengetahuan yang dipilih?`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    const form = document.getElementById('batch-form');
    
    // Set form action based on page type
    @if($pageType === 'verification')
        if (action === 'approve') {
            form.action = '{{ route("verifikasi.pengetahuan.batch.approve") }}';
        } else {
            form.action = '{{ route("verifikasi.pengetahuan.batch.reject") }}';
        }
    @else
        if (action === 'validate') {
            form.action = '{{ route("validasi.pengetahuan.batch.validate") }}';
        } else {
            form.action = '{{ route("validasi.pengetahuan.batch.reject") }}';
        }
    @endif
    
    // Remove existing hidden inputs
    const existingInputs = form.querySelectorAll('input[name="knowledge_ids[]"]');
    existingInputs.forEach(input => input.remove());
    
    // Add selected IDs as hidden inputs
    checkboxes.forEach(checkbox => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'knowledge_ids[]';
        hiddenInput.value = checkbox.value;
        form.appendChild(hiddenInput);
    });
    
    // Submit form
    form.submit();
}

// Initialize batch actions state on page load
document.addEventListener('DOMContentLoaded', function() {
    updateBatchActions();
});
</script>
@endif