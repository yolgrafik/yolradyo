@extends('layouts.frontend')

@section('title', 'Sponsorlar')

@section('content')
<section class="sponsorlar-page" style="max-width:1180px;margin:0 auto;padding:1.25rem 1rem 2rem;">
    <div class="sponsorlar-page__head" style="padding:.75rem 1rem;border-radius:var(--ry-radius);background:color-mix(in srgb, var(--ry-bar-bg) 85%, transparent);border:1px solid var(--ry-border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);margin-bottom:1rem;">
        <h1 class="sponsorlar-page__title" style="margin:0;font-size:clamp(.95rem,1.7vw,1.15rem);font-weight:700;color:var(--ry-text);">Sponsorlar</h1>
    </div>
    @include('partials.sponsor-list', ['sponsors' => $sponsors ?? collect()])
    @if(($sponsors ?? collect())->isEmpty())
        <div style="padding:1rem;text-align:center;color:var(--ry-text-muted);font-size:.95rem;">
            Henüz sponsor eklenmemiş.
        </div>
    @endif
</section>
@endsection
