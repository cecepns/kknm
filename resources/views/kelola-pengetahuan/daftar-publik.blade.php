@extends('layouts.dashboard')

@section('title', 'Repositori Pengetahuan KKN - KMS KKN')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Repositori Pengetahuan KKN</h1>
    </div>
</div>

<!-- ANCHOR: Search and Filters Section -->
<div class="search-filters-container">
    <!-- Search Bar -->
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input 
            type="text" 
            id="searchInput" 
            class="form-control" 
            placeholder="Cari pengetahuan..." 
            value="{{ request('search') }}"
        >
    </div>

    <!-- Filters Row -->
    <div class="filters-container">
        <div class="filter-group">
            <select id="categoryFilter" class="form-control">
                <option value="">Kategori</option>
                @foreach(\App\Helpers\UniversityDataHelper::getKnowledgeCategories() as $category)
                    <option value="{{ $category['value'] }}" {{ request('category') == $category['value'] ? 'selected' : '' }}>
                        {{ $category['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select id="fileTypeFilter" class="form-control">
                <option value="">Jenis File</option>
                @foreach(\App\Helpers\UniversityDataHelper::getJenisFile() as $fileType)
                    <option value="{{ $fileType['value'] }}" {{ request('file_type') == $fileType['value'] ? 'selected' : '' }}>
                        {{ $fileType['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select id="locationFilter" class="form-control">
                <option value="">Lokasi KKN</option>
                @foreach(\App\Helpers\UniversityDataHelper::getJenisKKN() as $location)
                    <option value="{{ $location['value'] }}" {{ request('location') == $location['value'] ? 'selected' : '' }}>
                        {{ $location['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select id="kknTypeFilter" class="form-control">
                <option value="">Jenis KKN</option>
                @foreach(\App\Helpers\UniversityDataHelper::getJenisKKN() as $kknType)
                    <option value="{{ $kknType['value'] }}" {{ request('kkn_type') == $kknType['value'] ? 'selected' : '' }}>
                        {{ $kknType['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select id="yearFilter" class="form-control">
                <option value="">Tahun KKN</option>
                @foreach(\App\Helpers\UniversityDataHelper::getTahunKKN() as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- ANCHOR: Knowledge Items Container -->
<div class="knowledge-items-container">
    @if($knowledgeItems->count() > 0)
        @foreach($knowledgeItems as $knowledge)
            <div class="knowledge-item">
                <div class="knowledge-content">
                    <h3 class="knowledge-title">{{ $knowledge->title }}</h3>
                    <div class="knowledge-metadata">
                        {{ \App\Helpers\UniversityDataHelper::getJenisFileLabel($knowledge->file_type) }} | 
                        {{ $knowledge->category ? $knowledge->category->name : \App\Helpers\UniversityDataHelper::getKnowledgeCategoryLabel($knowledge->category_id) }} | 
                        Diunggah oleh: {{ $knowledge->user->name }} | 
                        {{ $knowledge->created_at->format('Y-m-d') }}
                    </div>
                </div>
                <a href="{{ route('repositori.publik.detail', $knowledge) }}" class="btn btn-primary">
                    Lihat Detail
                </a>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $knowledgeItems->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <h3 class="empty-state-title">Tidak Ada Pengetahuan Ditemukan</h3>
            <p class="empty-state-description">
                Tidak ada pengetahuan yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau kata kunci pencarian.
            </p>
        </div>
    @endif
</div>

@endsection

<style>
/* ANCHOR: Search and Filters Styles */
.search-filters-container {
    margin-bottom: 2rem;
    width: 100%;
}

.search-container form {
    width: 100%;
}

.search-container {
    margin-bottom: 1rem;
}

.search-input-wrapper {
    position: relative;
    max-width: 600px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: border-color 0.15s ease-in-out;
}

.search-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.filters-container {
    display: flex;
    gap: 0.5rem;
}
/* ANCHOR: Knowledge Items Styles */
.knowledge-items-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.knowledge-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    transition: box-shadow 0.15s ease-in-out;
}

.knowledge-item:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.knowledge-content {
    flex: 1;
}

.knowledge-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.5rem;
}

.knowledge-metadata {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.knowledge-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    margin-left: 1rem;
}

.knowledge-icon i {
    font-size: 1.5rem;
    color: #495057;
}

/* ANCHOR: Pagination Styles */
.pagination-container {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* ANCHOR: Empty State Styles */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-title {
    font-size: 1.5rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state-description {
    color: #6c757d;
    margin-bottom: 0;
}

/* ANCHOR: Responsive Design */
@media (max-width: 768px) {
    
    .knowledge-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .knowledge-icon {
        margin-left: 0;
        margin-top: 1rem;
        align-self: center;
    }
}
</style>

<script>
// ANCHOR: Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const fileTypeFilter = document.getElementById('fileTypeFilter');
    const locationFilter = document.getElementById('locationFilter');
    const kknTypeFilter = document.getElementById('kknTypeFilter');
    const yearFilter = document.getElementById('yearFilter');


    // Function to update URL with current filters
    function updateFilters() {
        const params = new URLSearchParams();
        
        if (searchInput.value) params.append('search', searchInput.value);
        if (categoryFilter.value) params.append('category', categoryFilter.value);
        if (fileTypeFilter.value) params.append('file_type', fileTypeFilter.value);
        if (locationFilter.value) params.append('location', locationFilter.value);
        if (kknTypeFilter.value) params.append('kkn_type', kknTypeFilter.value);
        if (yearFilter.value) params.append('year', yearFilter.value);

        const url = new URL(window.location);
        url.search = params.toString();
        window.location.href = url.toString();
    }

    // Add event listeners
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            updateFilters();
        }
    });

    [categoryFilter, fileTypeFilter, locationFilter, kknTypeFilter, yearFilter].forEach(filter => {
        filter.addEventListener('change', updateFilters);
    });
});
</script>