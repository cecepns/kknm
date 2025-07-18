@extends('layouts.dashboard')

@section('title', 'Kelola FAQ')

@section('content')
<div class="faq-container">
    <header class="faq-header">
        <h1>Kelola FAQ</h1>
    </header>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="search-and-add">
        <div class="search-bar">
            <input type="text" placeholder="Search FAQ">
        </div>
        <a href="{{ route('form.tambah.kelola.faq') }}" class="btn-add-faq">
            Tambah FAQ
        </a>
    </div>

    <h2 class="faq-list-header">Frequently Asked Questions</h2>

    <div class="faq-list">
        @forelse($faqs as $faq)
        <div class="faq-item" style="display: flex; align-items: center">
            <p style="margin-right: 10px">{{ $faq->question }}</p>
            <p style="margin-right: 20px">{{ \Illuminate\Support\Str::limit($faq->answer, 100, '...') }}</p> 
            <a href="{{ route('form.edit.kelola.faq', $faq->id) }}">Edit</a> | 
            <form action="{{ route('hapus.kelola.faq', $faq->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                    Hapus
                </button>
            </form>
        </div>
        @empty
        <div class="faq-item">
            <p>Tidak ada data FAQ untuk ditampilkan.</p>
        </div>
        @endforelse
    </div>

    <hr class="dotted-line">
</div>
@endsection
