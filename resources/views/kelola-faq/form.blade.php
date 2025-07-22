@extends('layouts.dashboard')

@section('title', 'Form FAQ')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($faq) ? 'Edit FAQ' : 'Tambah FAQ Baru' }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ isset($faq) ? route('edit.kelola.faq', $faq->id) : route('tambah.kelola.faq') }}" method="POST">
            @csrf
            @if(isset($faq))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="question">Pertanyaan</label>
                <input type="text" class="form-control @error('question') error @enderror" id="question" name="question" value="{{ old('question', $faq->question ?? '') }}" required>
                @error('question')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="answer">Jawaban</label>
                <textarea class="form-control @error('answer') error @enderror" id="answer" name="answer" rows="6" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
                @error('answer')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-4">
                <a href="{{ route('daftar.kelola.faq') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
