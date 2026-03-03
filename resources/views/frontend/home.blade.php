@extends('layouts.frontend')

@section('title', 'Anasayfa')

@push('styles')
<style>
    .hero {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 3rem 1.5rem;
        background: linear-gradient(135deg, #1a0a0e 0%, #0f1319 40%, #1a0f12 100%);
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(201, 42, 42, 0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        letter-spacing: 0.12em;
        color: #fff;
        text-transform: none;
        margin-bottom: 2rem;
        text-shadow: 0 0 30px rgba(201, 42, 42, 0.3);
        position: relative;
        z-index: 1;
    }
    .hero-buttons {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        max-width: 600px;
        position: relative;
        z-index: 1;
    }
    .hero-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: none;
        color: #fff;
        text-decoration: none;
        background: linear-gradient(135deg, rgba(201, 42, 42, 0.9), rgba(150, 30, 30, 0.95));
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }
    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 30px rgba(201, 42, 42, 0.5), 0 8px 30px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 255, 255, 0.25);
    }
    @media (max-width: 600px) {
        .hero-buttons { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<section class="hero">
    <h1 class="hero-title">RADYOYOL</h1>
    <div class="hero-buttons">
        <a href="#" class="hero-btn">Canli Yayin</a>
        <a href="#" class="hero-btn">Yayin Akisi</a>
        <a href="#" class="hero-btn">DJ'lerimiz</a>
        <a href="#" class="hero-btn">Sarki Istek</a>
    </div>
</section>
@endsection
