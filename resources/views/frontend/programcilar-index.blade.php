@extends('layouts.frontend')

@section('title', 'Programcılar')

@section('content')
<div class="programlar-layout" style="max-width:1200px;margin:0 auto;padding:2rem 1rem;">
    <section class="programlar-hero" style="padding:2rem 0;margin-bottom:2rem;border-bottom:1px solid var(--ry-border);">
        <h1 style="font-size:2rem;font-weight:700;color:#fff;margin:0 0 0.5rem 0;">Programcılar</h1>
        <p style="color:var(--muted);font-size:1rem;margin:0;">Radyomuzun programcıları ile tanışın</p>
    </section>
    @include('partials.programcilar-cards')
</div>
@endsection
