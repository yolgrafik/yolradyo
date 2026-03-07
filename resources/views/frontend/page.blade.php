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
    }
    .page-content p,
    .page-content-body p {
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 1rem;
    }
    .page-content-body h2 { font-size: 1.25rem; font-weight: 700; color: #fff; margin: 1.5rem 0 0.75rem 0; }
    .page-content-body h3 { font-size: 1.1rem; font-weight: 600; color: #e5e7eb; margin: 1.25rem 0 0.5rem 0; }
    .page-content-body ul, .page-content-body ol { margin: 0.75rem 0 1rem 1.5rem; color: var(--muted); line-height: 1.7; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $pageTitle ?? 'Sayfa' }}</h1>
</section>
<div class="page-content">
    @if(!empty(trim($pageContent ?? '')))
        <div class="page-content-body">
            {!! $pageContent !!}
        </div>
    @else
        <p>Bu sayfa içeriği yakında eklenecektir.</p>
    @endif
</div>
@endsection
