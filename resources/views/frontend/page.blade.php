@extends('layouts.frontend')

@section('title', $pageTitle ?? 'Sayfa')

@push('styles')
<style>
    .page-hero {
        padding: 2.5rem 1.5rem;
        background: var(--ry-header-bg);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
    }
    .page-hero h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        text-transform: none;
        max-width: 1200px;
        margin: 0 auto;
    }
    .page-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
        background: linear-gradient(180deg, #1a2230 0%, #0f1622 100%);
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.22);
    }
    .page-content p,
    .page-content-body p {
        color: #dbe3ef;
        line-height: 1.9;
        margin-bottom: 1.2rem;
    }
    .page-summary {
        font-size: 1rem;
        color: #e5e7eb;
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    .page-cover-wrap {
        margin-bottom: 1.25rem;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        background: rgba(255,255,255,0.03);
    }
    .page-cover {
        display: block;
        width: 100%;
        max-height: 420px;
        object-fit: cover;
    }
    .page-content-body {
        background: rgba(20, 25, 35, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        padding: 35px;
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.18);
    }
    .page-content-body h2 { font-size: 1.25rem; font-weight: 700; color: #fff; margin: 1.5rem 0 0.75rem 0; }
    .page-content-body h3 { font-size: 1.1rem; font-weight: 600; color: #e5e7eb; margin: 1.25rem 0 0.5rem 0; }
    .page-content-body ul, .page-content-body ol { margin: 0.75rem 0 1rem 1.5rem; color: #dbe3ef; line-height: 1.85; }
    @media (max-width: 768px) {
        .page-content {
            padding: 1.25rem 1rem;
        }
        .page-content-body {
            padding: 22px;
        }
    }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $pageTitle ?? 'Sayfa' }}</h1>
</section>
<div class="page-content">
    @if(!empty($pageDescription))
        <p class="page-summary">{{ $pageDescription }}</p>
    @endif
    @if(!empty($pageImage))
        <div class="page-cover-wrap">
            <img src="{{ asset($pageImage) }}" alt="{{ $pageTitle ?? 'Sayfa' }}" class="page-cover">
        </div>
    @endif
    @if(!empty(trim($pageContent ?? '')))
        <div class="page-content-body">
            {!! $pageContent !!}
        </div>
    @else
        <p>Bu sayfa içeriği yakında eklenecektir.</p>
    @endif
</div>
@endsection
