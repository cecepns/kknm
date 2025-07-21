@extends('layouts.dashboard')

@section('title', 'Pertanyaan Umum (FAQ)')

@section('content')
<div class="faq-container">
    <h1 style="text-align: center; margin-bottom: 2rem; color: #2d3748;">Pertanyaan Umum (FAQ)</h1>

    @forelse ($faqs as $faq)
        <div class="faq-item">
            <details>
                <summary class="faq-question">
                    {{ $faq->question }}
                </summary>
                <div class="faq-answer">
                    <p>{!! nl2br(e($faq->answer)) !!}</p>
                </div>
            </details>
        </div>
    @empty
        <div style="text-align: center; padding: 2rem; color: #718096;">
            <p>Saat ini belum ada FAQ yang tersedia.</p>
        </div>
    @endforelse
</div>
@endsection
