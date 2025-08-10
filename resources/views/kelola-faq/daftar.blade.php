@extends('layouts.dashboard')

@section('title', 'Kelola FAQ')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola FAQ</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="search-container">
    <div class="search-bar">
        <input type="text" class="form-control" placeholder="Search FAQ" id="searchFaq">
    </div>
    <a href="{{ route('form.tambah.kelola.faq') }}" class="btn btn-primary">
        + Tambah FAQ
    </a>
</div>

<div class="faq-section">
    <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">Frequently Asked Questions</h2>
    
    <div class="grid grid-cols-2 gap-6">
        @forelse($faqs as $faq)
        <div class="faq-card" data-question="{{ strtolower($faq->question) }}" data-answer="{{ strtolower($faq->answer) }}">
            <div class="faq-card-header">
                <h3 class="faq-question">{{ $faq->question }}</h3>
                <div class="faq-actions">
                    <a href="{{ route('form.edit.kelola.faq', $faq->id) }}" class="btn-edit">✏️</a>
                    <form action="{{ route('hapus.kelola.faq', $faq->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
            <div class="faq-card-body">
                <p class="faq-answer">{{ \Illuminate\Support\Str::limit($faq->answer, 150, '...') }}</p>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">❓</div>
            <h3>Tidak ada FAQ</h3>
            <p class="text-gray-500">Belum ada FAQ yang ditambahkan. Mulai dengan menambahkan FAQ pertama Anda.</p>
            <a href="{{ route('form.tambah.kelola.faq') }}" class="btn btn-primary">Tambah FAQ Pertama</a>
        </div>
        @endforelse
    </div>
</div>

<script>
document.getElementById('searchFaq').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const faqCards = document.querySelectorAll('.faq-card');
    
    faqCards.forEach(card => {
        const question = card.getAttribute('data-question');
        const answer = card.getAttribute('data-answer');
        
        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection
