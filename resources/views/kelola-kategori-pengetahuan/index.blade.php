@extends('layouts.dashboard')

@section('title', 'Kelola Kategori Pengetahuan - KMS KKN')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Kategori Pengetahuan</h1>
    </div>
    <div>
        <a href="{{ route('kelola.kategori.pengetahuan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
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

<!-- ANCHOR: Categories List -->
@if($categories->count() > 0)
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Jumlah Pengetahuan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->knowledgeItems()->count() }}</td>
                        <td>{{ $category->created_at->format('d F Y H:i') }}</td>
                        <td class="action">
                            <a href="{{ route('kelola.kategori.pengetahuan.edit', $category) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('kelola.kategori.pengetahuan.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state">
        <h3 class="empty-state-title">Belum Ada Kategori</h3>
        <p class="empty-state-description">
            Belum ada kategori pengetahuan yang dibuat. Mulai tambahkan kategori pertama Anda!
        </p>
        <a href="{{ route('kelola.kategori.pengetahuan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori Pertama
        </a>
    </div>
@endif

<style>
.table-container {
    margin-top: 2rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.action {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 2rem;
}

.empty-state-title {
    font-size: 1.5rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state-description {
    color: #6c757d;
    margin-bottom: 2rem;
}
</style>
@endsection 