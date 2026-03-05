@extends('layouts.frontend')

@section('title', 'Anasayfa')

@push('styles')
<style>
    .home-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1rem;
        overflow-x: hidden;
        min-width: 0;
    }
    .home-main {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 2rem;
        align-items: start;
        min-width: 0;
    }
    .home-left {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
    }
    .home-slider-wrap {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        min-width: 0;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        min-height: 386px;
        background: var(--panel);
        border: 1px solid var(--border);
    }
    .home-slider {
        position: relative;
        width: 100%;
        min-height: 386px;
        overflow: hidden;
        perspective: 1200px;
    }
    .home-slider__slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        background-size: cover;
        background-position: center;
        transform: scale(1);
        transition: opacity 0.9s cubic-bezier(0.4, 0, 0.2, 1), transform 0.9s cubic-bezier(0.4, 0, 0.2, 1), filter 0.9s ease;
        filter: blur(0);
        backface-visibility: hidden;
    }
    .home-slider__slide.is-active {
        opacity: 1;
        z-index: 1;
        transform: scale(1);
        filter: blur(0);
    }
    .home-slider__slide.is-exiting { }
    .home-slider__slide.effect-fade.is-exiting { opacity: 0; }
    .home-slider__slide.effect-fade:not(.is-active) { opacity: 0; }
    .home-slider__slide.effect-slide-left { transform: translateX(100%); }
    .home-slider__slide.effect-slide-left.is-active { transform: translateX(0); }
    .home-slider__slide.effect-slide-left.is-exiting { transform: translateX(-100%); }
    .home-slider__slide.effect-slide-right { transform: translateX(-100%); }
    .home-slider__slide.effect-slide-right.is-active { transform: translateX(0); }
    .home-slider__slide.effect-slide-right.is-exiting { transform: translateX(100%); }
    .home-slider__slide.effect-zoom { transform: scale(0.7); opacity: 0; }
    .home-slider__slide.effect-zoom.is-active { transform: scale(1); opacity: 1; }
    .home-slider__slide.effect-zoom.is-exiting { transform: scale(1.1); opacity: 0; }
    .home-slider__slide.effect-blur { filter: blur(12px); opacity: 0; }
    .home-slider__slide.effect-blur.is-active { filter: blur(0); opacity: 1; }
    .home-slider__slide.effect-blur.is-exiting { filter: blur(8px); opacity: 0; }
    .home-slider__slide.effect-rotate { transform: perspective(1200px) rotateY(-95deg); opacity: 0; }
    .home-slider__slide.effect-rotate.is-active { transform: perspective(1200px) rotateY(0); opacity: 1; }
    .home-slider__slide.effect-rotate.is-exiting { transform: perspective(1200px) rotateY(95deg); opacity: 0; }
    .home-slider__slide::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
        pointer-events: none;
    }
    .home-slider__content {
        position: relative;
        z-index: 2;
        padding: 2rem;
        max-width: 60%;
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .home-slider__title,
    .home-slider__subtitle,
    .home-slider__btn {
        opacity: 0;
        transform: translateX(-40px) translateY(15px);
        transition: opacity 0.55s ease, transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .home-slider__slide.is-active .home-slider__title {
        opacity: 1;
        transform: translateX(0);
        transition-delay: 0.1s;
    }
    .home-slider__slide.is-active .home-slider__subtitle {
        opacity: 1;
        transform: translateX(0);
        transition-delay: 0.25s;
    }
    .home-slider__slide.is-active .home-slider__btn {
        opacity: 1;
        transform: translateX(0);
        transition-delay: 0.4s;
    }
    .home-slider__title {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }
    .home-slider__subtitle {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        margin: 0;
        text-shadow: 0 1px 4px rgba(0,0,0,0.5);
    }
    .home-slider__btn {
        display: inline-block;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: var(--ry-radius);
        transition: all 0.2s ease;
        border: 1px solid var(--ry-btn-bg);
        margin-top: 0.25rem;
    }
    .home-slider__btn:hover { transform: translateX(0) translateY(-1px); }
    .home-slider__nav {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        gap: 0.5rem;
    }
    .home-slider__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: background 0.2s;
    }
    .home-slider__dot.is-active { background: rgba(255,255,255,0.9); }
    .home-slider-placeholder {
        min-height: 386px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 1.25rem;
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 14px;
    }
    .schedule-card {
        position: relative;
        background: var(--ry-bar-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.04);
        min-width: 0;
    }
    .schedule-card::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 4%, var(--ry-line-color) 12%, var(--ry-line-color) 88%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 96%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }
    .schedule-card::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 4%, var(--ry-line-color) 12%, var(--ry-line-color) 88%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 96%, transparent 100%);
        pointer-events: none;
    }
    .schedule-top-bar {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.6rem 1rem 0.5rem;
        background: rgba(255, 255, 255, 0.02);
    }
    .schedule-top-bar::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 4%, var(--ry-line-color) 12%, var(--ry-line-color) 88%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 96%, transparent 100%);
        pointer-events: none;
    }
    .schedule-top-bar__title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text);
        flex-shrink: 0;
    }
    .schedule-top-bar__icon { font-size: 1.1rem; }
    .schedule-days-bar {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
        flex: 1;
        min-width: 0;
        width: 100%;
    }
    .schedule-day {
        flex: 1 1 0;
        min-width: 0;
        padding: 6px 8px;
        border-radius: 8px;
        background: var(--ry-schedule-bg);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-family: Arial, sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .schedule-day:hover {
        background: var(--ry-surface-2);
        border-color: rgba(255,255,255,0.25);
    }
    .schedule-day.active {
        background: var(--ry-schedule-active);
        border: none;
        color: #ffffff;
    }
    .schedule-list-wrap {
        padding: 0 1rem 1rem;
        min-width: 0;
        overflow: hidden;
    }
    .schedule-strip {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        align-content: stretch;
        gap: 6px;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        padding: 8px 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        margin-top: 8px;
        min-height: 44px;
    }
    .schedule-chip {
        display: inline-flex;
        flex: 1 1 auto;
        min-width: 80px;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--ry-schedule-bg);
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 0.8rem;
        font-weight: 700;
        color: #ffffff;
        overflow: hidden;
    }
    .schedule-chip .sep { opacity: 0.6; font-weight: 900; flex-shrink: 0; }
    .schedule-strip .dot { opacity: 0.35; flex-shrink: 0; }
    .schedule-chip.is-live {
        background: var(--ry-schedule-active);
        border: none;
        color: #ffffff;
    }
    .schedule-chip .live-badge {
        margin-left: 4px;
        padding: 1px 5px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.25);
        font-size: 0.65rem;
        font-weight: 900;
    }
    .home-right {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
        max-width: 360px;
    }
    .home-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: var(--ry-radius);
        background: var(--ry-istekler-bg);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .btn-live {
        display: grid;
        place-items: center;
        padding: 1rem 1.5rem;
        cursor: pointer;
        font-family: inherit;
        border-radius: var(--ry-radius);
        font-family: Arial, sans-serif;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        text-transform: none;
        transition: all 0.2s ease;
    }
    .btn-live:hover { transform: translateY(-2px); }
    .btn-request-group {
        display: flex;
        flex: 1;
        border-radius: var(--ry-radius);
        overflow: hidden;
    }
    .btn-request {
        flex: 1;
        display: grid;
        place-items: center;
        cursor: pointer;
        font-family: inherit;
        padding: 1rem 1rem;
        border-right: none;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: none;
        white-space: nowrap;
        transition: all 0.25s ease;
    }
    .btn-request-group > *:last-child { border-right: 1px solid rgba(255,255,255,0.2); }
    .btn-whatsapp-istek {
        flex: 1;
        display: grid;
        place-items: center;
        padding: 1rem 1rem;
        border-left: none;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        text-transform: none;
        white-space: nowrap;
        transition: all 0.25s ease;
    }
    .btn-whatsapp-disabled {
        cursor: default;
        opacity: 0.7;
        pointer-events: none;
    }
    .home-icon-buttons {
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 0.2rem;
        padding: 0.12rem 0.4rem;
        background: color-mix(in srgb, var(--ry-bar-bg) 65%, #0b0f16);
        border: 1px solid var(--border);
        border-radius: 6px;
        width: 100%;
        box-sizing: border-box;
        flex-wrap: wrap;
    }
    .home-icon-buttons a.icon-link {
        flex: 1 1 0;
        min-width: 0;
        aspect-ratio: 1;
        padding: 0.16rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: opacity 0.2s ease;
    }
    .home-icon-buttons a.icon-link:hover {
        opacity: 0.85;
    }
    .home-icon-buttons .player-icon-img {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transform: scale(0.58);
    }
    .home-badges {
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: color-mix(in srgb, var(--ry-bar-bg) 65%, #0b0f16);
        border: 1px solid var(--border);
        border-radius: 10px;
        width: 100%;
        box-sizing: border-box;
    }
    .home-badges .badge-link-item {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1 1 0;
        min-width: 0;
        transition: opacity 0.2s ease;
    }
    .home-badges .badge-link-item:hover {
        opacity: 0.85;
    }
    .home-badges .store-badge {
        width: 100%;
        max-width: 100%;
        height: auto;
        max-height: 59px;
        object-fit: contain;
        display: block;
    }
    .live-dj-card {
        position: relative;
        background: color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    .live-dj-card::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 4%, var(--ry-line-color) 12%, var(--ry-line-color) 88%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 96%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }
    .live-banner {
        background: var(--ry-bar-bg);
        color: #ffffff;
        font-weight: 900;
        font-size: 14px;
        padding: 10px 14px;
        letter-spacing: 2px;
        border-bottom: 1px solid var(--ry-line-color);
    }
    .live-content {
        padding: 14px;
        transition: opacity 0.3s ease;
    }
    .live-content.updating {
        opacity: 0.6;
    }
    .live-dj-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .live-dj-photo-wrap {
        width: 64px;
        height: 64px;
        min-width: 64px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid var(--border);
        background: rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--muted);
    }
    .live-dj-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .live-dj-info {
        flex: 1;
        min-width: 0;
    }
    .live-dj-name {
        font-size: 18px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.2;
    }
    .live-dj-details {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid var(--ry-line-color);
    }
    .live-program {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 4px;
    }
    .live-tagline {
        font-size: 12px;
        color: var(--muted);
        opacity: 0.85;
        margin-bottom: 10px;
    }
    .live-live-wrap {
        position: relative;
        display: inline-block;
        padding-bottom: 6px;
    }
    .live-live-btn {
        position: relative;
        background: var(--ry-schedule-active);
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        display: inline-block;
        letter-spacing: 1px;
    }
    .live-live-btn::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -4px;
        height: 2px;
        background: rgba(255,255,255,0.5);
        opacity: 0.7;
        border-radius: 2px;
    }
    .live-dj-card .live-empty {
        color: var(--muted);
        padding: 1rem 0;
        text-align: center;
    }
    .live-meta {
        padding: 10px 14px;
        border-top: 1px solid var(--ry-line-color);
        font-size: 11px;
        color: var(--muted);
        background: color-mix(in srgb, var(--ry-bar-bg) 55%, #0b0f16);
    }
    .live-track {
        margin-bottom: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .live-listeners { margin-bottom: 0; }
    .live-meta .cc_streaminfo { color: var(--text); opacity: 0.9; }
    .listener-widget {
        position: relative;
        background: color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }
    .listener-widget::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 4%, var(--ry-line-color) 12%, var(--ry-line-color) 88%, color-mix(in srgb, var(--ry-line-color) 30%, transparent) 96%, transparent 100%);
        pointer-events: none;
        z-index: 1;
    }
    .listener-widget__header {
        background: var(--ry-bar-bg);
        color: #ffffff;
        font-weight: 900;
        font-size: 13px;
        padding: 10px 14px;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--ry-line-color);
    }
    .listener-widget__body {
        padding: 0;
        min-height: 220px;
    }
    .listener-swiper-wrap {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    .listener-swiper {
        overflow: hidden;
        padding: 12px;
    }
    .listener-swiper .swiper-wrapper { align-items: stretch; }
    .listener-swiper .swiper-slide {
        height: auto;
        display: flex;
    }
    .listener-slide {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.3);
    }
    .listener-slide__link {
        display: block;
        width: 100%;
        text-decoration: none;
        color: inherit;
    }
    .listener-slide__img,
    .listener-slide__thumb {
        width: 100%;
        aspect-ratio: 16/10;
        object-fit: cover;
        display: block;
    }
    .listener-slide__thumb {
        background-size: cover;
        background-position: center;
        background-color: rgba(0, 0, 0, 0.5);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .listener-slide__play {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(201, 42, 42, 0.9);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        padding-left: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }
    .listener-slide__caption {
        padding: 8px 10px;
        background: rgba(0, 0, 0, 0.4);
        font-size: 0.8rem;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .listener-slide__name {
        font-weight: 600;
        color: #fff;
    }
    .listener-slide__title {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.75rem;
    }
    .listener-slide__desc {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.7rem;
        margin-top: 2px;
    }
    .listener-swiper .listener-swiper-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        margin: 0;
        border-radius: 50%;
        background: color-mix(in srgb, var(--ry-bar-bg) 90%, transparent);
        border: 1px solid var(--border);
        color: var(--ry-text);
        z-index: 10;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.2s;
    }
    .listener-swiper .listener-swiper-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: var(--ry-line-color);
    }
    .listener-swiper .listener-swiper-btn--prev { left: 4px; }
    .listener-swiper .listener-swiper-btn--next { right: 4px; }
    .listener-swiper .swiper-button-disabled { opacity: 0.35; pointer-events: none; }
    .listener-swiper-pagination {
        position: relative;
        margin-top: 8px;
    }
    .listener-swiper-pagination .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.4);
        opacity: 1;
    }
    .listener-swiper-pagination .swiper-pagination-bullet-active {
        background: var(--ry-schedule-active);
    }
    @media (max-width: 992px) {
        .home-main {
            grid-template-columns: 1fr;
        }
        .home-left { order: 1; }
        .home-right {
            order: 2;
            max-width: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .home-actions {
            grid-column: 1 / -1;
            flex-direction: row;
        }
        .btn-live, .btn-request-group { flex: 1; }
        .listener-widget {
            grid-column: 1 / -1;
        }
        .live-dj-card {
            grid-column: 1 / -1;
        }
    }
    @media (max-width: 768px) {
        .home-slider__content { padding: 1.5rem; max-width: 85%; }
        .home-slider__title { font-size: 1.5rem; }
        .home-slider__subtitle { font-size: 0.95rem; }
        .schedule-day { padding: 4px 8px; font-size: 0.7rem; min-height: 26px; }
        .schedule-chip { font-size: 0.75rem; padding: 4px 8px; }
        .live-banner { font-size: 12px; padding: 8px; }
        .live-dj-name { font-size: 16px; }
        .live-dj-photo-wrap { width: 52px; height: 52px; min-width: 52px; font-size: 1.2rem; }
        .live-program { font-size: 12px; }
    }
    @media (max-width: 600px) {
        .home-layout { padding: 1rem; }
        .schedule-top-bar { flex-direction: column; align-items: stretch; }
        .schedule-days-bar { justify-content: flex-start; flex-wrap: wrap; }
        .schedule-chip { font-size: 0.72rem; padding: 4px 7px; }
        .home-right {
            grid-template-columns: 1fr;
        }
        .home-actions { flex-direction: column; }
        .btn-request, .btn-whatsapp-istek { font-size: 0.8rem; padding: 0.9rem 0.75rem; }
    }
</style>
@endpush

@section('content')
<div class="home-layout">
    <div class="home-main">
        <div class="home-left">
            @if(isset($sliders) && $sliders->isNotEmpty())
            <div class="home-slider-wrap">
                <div class="home-slider" id="homeSlider">
                    @foreach($sliders as $i => $s)
                    <div class="home-slider__slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" style="background-image: url('{{ asset($s->image_path) }}');">
                        <div class="home-slider__content">
                            <h2 class="home-slider__title">{{ $s->title }}</h2>
                            @if($s->subtitle)<p class="home-slider__subtitle">{{ $s->subtitle }}</p>@endif
                            @if($s->button_text && $s->button_link)<a href="{{ url($s->button_link) }}" class="home-slider__btn ry-btn ry-btn-primary">{{ $s->button_text }}</a>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($sliders->count() > 1)
                <div class="home-slider__nav" id="sliderNav">
                    @foreach($sliders as $i => $s)
                    <button type="button" class="home-slider__dot {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="home-slider-placeholder">Slider</div>
            @endif
            <div class="schedule-card">
                <div class="schedule-top-bar">
                    <span class="schedule-top-bar__title">
                        <span class="schedule-top-bar__icon">📻</span>
                        Yayın Akışı
                    </span>
                    <div class="schedule-days-bar">
                        <button type="button" class="schedule-day" data-day="0">Pazartesi</button>
                        <button type="button" class="schedule-day" data-day="1">Salı</button>
                        <button type="button" class="schedule-day" data-day="2">Çarşamba</button>
                        <button type="button" class="schedule-day" data-day="3">Perşembe</button>
                        <button type="button" class="schedule-day" data-day="4">Cuma</button>
                        <button type="button" class="schedule-day" data-day="5">Cumartesi</button>
                        <button type="button" class="schedule-day" data-day="6">Pazar</button>
                    </div>
                </div>
                <div class="schedule-list-wrap">
                    <div class="schedule-list" id="scheduleListContainer">
                        <div class="schedule-loading" id="scheduleLoading">Yükleniyor...</div>
                        <div class="schedule-empty" id="scheduleEmpty" style="display:none;padding:2.5rem;text-align:center;color:rgba(255,255,255,0.6);font-size:0.95rem;margin-top:14px;">Bu gün için program yok.</div>
                    </div>
                </div>
            </div>
            @include('partials.requests-ticker')
            @include('partials.programcilar-cards')
        </div>
        <div class="home-right">
            <div class="home-actions">
                <button type="button" class="btn-live glass-btn ry-btn ry-btn-primary" id="openLivePlayer">CANLI DİNLE</button>
                <div class="btn-request-group">
                    <button type="button" class="btn-request ry-btn ry-btn-primary" data-open-song-request>İstek Gönder</button>
                    @php
                        $wa = $socialLinks['whatsapp'] ?? ['url' => '', 'is_active' => false];
                        $waActive = ($wa['is_active'] ?? false) && !empty(trim($wa['url'] ?? ''));
                        $waUrl = $waActive ? (rtrim($wa['url']) . (str_contains($wa['url'], '?') ? '&' : '?') . 'text=' . urlencode('Merhaba, şarkı isteği göndermek istiyorum.')) : '#';
                    @endphp
                    @if($waActive)
                    <a href="{{ $waUrl }}" class="btn-whatsapp-istek ry-btn ry-btn-primary" target="_blank" rel="noopener noreferrer" title="WhatsApp ile İstek Gönder">WhatsApp İstek</a>
                    @else
                    <span class="btn-whatsapp-istek btn-whatsapp-disabled ry-btn" title="WhatsApp adresi ayarlardan eklenebilir">WhatsApp İstek</span>
                    @endif
                </div>
            </div>
            <div class="home-icon-buttons">
                @php
                    $playerLinks = [
                        'winamp' => ['label' => 'Winamp İle Dinle', 'img' => 'winamp.png'],
                        'media_player' => ['label' => 'Medya Player', 'img' => 'medya-player.png'],
                        'quicktime' => ['label' => 'QuickTime Player', 'img' => 'quicktime.png'],
                        'real_player' => ['label' => 'Real Player', 'img' => 'real-player.png'],
                    ];
                @endphp
                @foreach($playerLinks as $key => $info)
                    @if(isset($socialLinks[$key]) && ($socialLinks[$key]['is_active'] ?? false) && !empty(trim($socialLinks[$key]['url'] ?? '')))
                    <a href="{{ $socialLinks[$key]['url'] }}" class="icon-placeholder icon-link" target="_blank" rel="noopener noreferrer" title="{{ $info['label'] }}" aria-label="{{ $info['label'] }}">
                        <img src="{{ asset('assets/images/' . $info['img']) }}" alt="{{ $info['label'] }}" class="player-icon-img">
                    </a>
                    @endif
                @endforeach
            </div>
            <div class="home-badges">
                @if(isset($socialLinks['android_app']) && ($socialLinks['android_app']['is_active'] ?? false) && !empty(trim($socialLinks['android_app']['url'] ?? '')))
                <a href="{{ $socialLinks['android_app']['url'] }}" class="badge-link-item" target="_blank" rel="noopener noreferrer" title="Android Uygulaması">
                    <img src="{{ asset('assets/images/google-play.png') }}" alt="GET IT ON Google Play" class="store-badge">
                </a>
                @endif
                @if(isset($socialLinks['ios_app']) && ($socialLinks['ios_app']['is_active'] ?? false) && !empty(trim($socialLinks['ios_app']['url'] ?? '')))
                <a href="{{ $socialLinks['ios_app']['url'] }}" class="badge-link-item" target="_blank" rel="noopener noreferrer" title="iOS Uygulaması">
                    <img src="{{ asset('assets/images/app-store.png') }}" alt="Download on the App Store" class="store-badge">
                </a>
                @endif
            </div>
            @include('partials.listener-submissions-widget')
            <div class="live-dj-card" id="liveDjCard">
                <div class="live-banner">CANLI YAYINDA</div>
                <div class="live-content" id="liveDjCardContent">
                    <p style="margin:0;color:#fff;opacity:.8;">Yükleniyor...</p>
                </div>
                <div class="live-meta">
                    <div class="live-track">🎵 <span class="cc_streaminfo" data-type="tracktitle" data-username="radyoyol"></span></div>
                    <div class="live-listeners">👥 <span class="cc_streaminfo" data-type="listeners" data-username="radyoyol"></span> dinleyici</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var dayBtns = document.querySelectorAll('.schedule-day');
    var container = document.getElementById('scheduleListContainer');
    var loadingEl = document.getElementById('scheduleLoading');
    var emptyEl = document.getElementById('scheduleEmpty');
    var currentDay = (function(){ var d=new Date().getDay(); return d===0?6:d-1; })();

    function renderSchedule(items) {
        if (!container) return;
        if (loadingEl) loadingEl.style.display='none';
        if (emptyEl) emptyEl.style.display=items.length===0?'block':'none';
        container.querySelectorAll('.schedule-strip').forEach(function(el){ el.remove(); });
        if (items.length===0) return;
        var strip = document.createElement('div');
        strip.className = 'schedule-strip';
        items.forEach(function(it, i){
            var chip = document.createElement('span');
            chip.className = 'schedule-chip' + (it.is_live ? ' is-live' : '');
            chip.appendChild(document.createTextNode(it.title || ''));
            var hostName = (it.dj && it.dj.name) ? it.dj.name : '';
            if (hostName) {
                var sep = document.createElement('span');
                sep.className = 'sep';
                sep.textContent = '|';
                chip.appendChild(document.createTextNode(' '));
                chip.appendChild(sep);
                chip.appendChild(document.createTextNode(' ' + hostName));
            }
            if (it.is_live) {
                var badge = document.createElement('span');
                badge.className = 'live-badge';
                badge.textContent = 'CANLI';
                chip.appendChild(document.createTextNode(' '));
                chip.appendChild(badge);
            }
            strip.appendChild(chip);
            if (i < items.length - 1) {
                var dot = document.createElement('span');
                dot.className = 'dot';
                dot.textContent = '•';
                strip.appendChild(dot);
            }
        });
        container.appendChild(strip);
    }

    function esc(s) { return (s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function renderLiveCard(activeDj) {
        var cardContent = document.getElementById('liveDjCardContent');
        if (!cardContent) return;
        cardContent.classList.add('updating');
        setTimeout(function() {
        if (activeDj) {
            var html = '<div class="live-dj-row">';
            if (activeDj.avatar_url) {
                html += '<div class="live-dj-photo-wrap"><img src="' + esc(activeDj.avatar_url) + '" alt="' + esc(activeDj.name) + '" class="live-dj-photo"></div>';
            } else {
                html += '<div class="live-dj-photo-wrap">' + esc(activeDj.initials || '?') + '</div>';
            }
            html += '<div class="live-dj-info"><h2 class="live-dj-name">' + esc(activeDj.name) + '</h2></div></div>';
            html += '<div class="live-dj-details">';
            if (activeDj.program_title) html += '<div class="live-program">' + esc(activeDj.program_title) + '</div>';
            if (activeDj.tagline) html += '<div class="live-tagline">' + esc(activeDj.tagline) + '</div>';
            html += '<div class="live-live-wrap"><span class="live-live-btn">CANLI YAYINDA</span></div></div>';
            cardContent.innerHTML = html;
            cardContent.classList.add('has-dj');
            cardContent.classList.remove('empty');
        } else {
            cardContent.innerHTML = '<p class="live-empty">Şu an canlı yayın yok</p>';
            cardContent.classList.remove('has-dj');
            cardContent.classList.add('empty');
        }
        cardContent.classList.remove('updating');
        }, 50);
    }

    function loadSchedule(day) {
        if (loadingEl) loadingEl.style.display='block';
        if (emptyEl) emptyEl.style.display='none';
        fetch('{{ url("/api/schedule") }}?day=' + day)
            .then(function(r){ return r.json(); })
            .then(function(data){
                renderSchedule(data.items || []);
                renderLiveCard(data.activeDj || null);
            })
            .catch(function(){
                renderSchedule([]);
                renderLiveCard(null);
            });
    }

    dayBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var day = parseInt(btn.getAttribute('data-day'), 10);
            dayBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            loadSchedule(day);
        });
    });

    dayBtns.forEach(function(b){ b.classList.remove('active'); });
    var activeBtn = Array.from(dayBtns).find(function(b){ return parseInt(b.getAttribute('data-day'),10)===currentDay; });
    if (activeBtn) activeBtn.classList.add('active');
    var selectedDay = currentDay;
    loadSchedule(selectedDay);
    setInterval(function(){
        var btn = Array.from(dayBtns).find(function(b){ return b.classList.contains('active'); });
        selectedDay = btn ? parseInt(btn.getAttribute('data-day'),10) : currentDay;
        loadSchedule(selectedDay);
    }, 60000);

    var slider = document.getElementById('homeSlider');
    var nav = document.getElementById('sliderNav');
    if (slider && nav) {
        var slides = slider.querySelectorAll('.home-slider__slide');
        var dots = nav.querySelectorAll('.home-slider__dot');
        var current = 0;
        var total = slides.length;
        var isTransitioning = false;
        var effects = ['effect-fade', 'effect-slide-left', 'effect-slide-right', 'effect-zoom', 'effect-blur', 'effect-rotate'];
        var effectIndex = 0;

        function getNextEffect() {
            var e = effects[effectIndex % effects.length];
            effectIndex++;
            return e;
        }

        function goTo(i) {
            if (isTransitioning || i === current) return;
            isTransitioning = true;
            var prev = current;
            var next = (i + total) % total;
            var effect = getNextEffect();
            var dir = next > prev || (prev === total - 1 && next === 0) ? 1 : -1;
            if (effect === 'effect-slide-left' && dir < 0) effect = 'effect-slide-right';
            else if (effect === 'effect-slide-right' && dir < 0) effect = 'effect-slide-left';
            slides[prev].classList.remove('is-active');
            slides[prev].className = slides[prev].className.replace(/\beffect-\w+/g, '').trim();
            slides[prev].classList.add(effect, 'is-exiting');
            slides[next].className = slides[next].className.replace(/\beffect-\w+/g, '').trim();
            slides[next].classList.add(effect);
            slides[next].classList.remove('is-exiting');
            current = next;
            dots.forEach(function(d, idx) {
                d.classList.toggle('is-active', idx === current);
            });
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    slides[next].classList.add('is-active');
                });
            });
            setTimeout(function() {
                slides[prev].classList.remove('is-exiting', effect);
                slides[next].classList.remove(effect);
                isTransitioning = false;
            }, 950);
        }

        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() { goTo(i); });
        });

        setInterval(function() {
            if (total > 1) goTo(current + 1);
        }, 5000);
    }
})();
</script>
@endpush
@endsection
