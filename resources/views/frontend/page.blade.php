@extends('layouts.frontend')

@section('title', $pageTitle ?? 'Sayfa')

@push('styles')
<style>
    .page-hero {
        padding: 2.5rem 1.5rem;
        background: var(--ry-header-bg);
        border-bottom: 1px solid var(--ry-border);
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
    .page-content p {
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $pageTitle ?? 'Sayfa' }}</h1>
</section>
<div class="page-content">
    <p>Bu sayfa icerigi yakinda eklenecektir.</p>
</div>
@endsection
