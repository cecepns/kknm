@extends('layouts.dashboard')

@section('title', 'Form FAQ')

@section('content')

<div class="form-container">
    <header class="form-header">
        <h1>{{ isset($faq) ? 'Edit FAQ' : 'Tambah FAQ Baru' }}</h1>
    </header>

    <form action="{{ isset($faq) ? route('edit.kelola.faq', $faq->id) : route('tambah.kelola.faq') }}" method="POST">
        @csrf
        @if(isset($faq))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="question">Pertanyaan</label>
            <input type="text" id="question" name="question" value="{{ old('question', $faq->question ?? '') }}" required>
            @error('question')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="answer">Jawaban</label>
            <textarea id="answer" name="answer" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
            @error('answer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('daftar.kelola.faq') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
