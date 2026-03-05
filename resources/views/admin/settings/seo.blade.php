@extends('admin.layouts.app')

@section('content')
@php
    $lastSaved = $seo_last_saved ?? null;
    $siteName = $site_name ?? 'RADYOYOL';
    $lastSavedFormatted = null;
    if ($lastSaved) {
        try {
            $lastSavedFormatted = \Carbon\Carbon::parse($lastSaved)->format('d.m.Y H:i');
        } catch (\Exception $e) {
            $lastSavedFormatted = $lastSaved;
        }
    }
@endphp
<div class="seo-page">
    {{-- Page Header --}}
    <header class="seo-header">
        <div class="seo-header__left">
            <h1 class="seo-header__title">SEO Ayarları</h1>
            <p class="seo-header__subtitle">Arama motorları ve sosyal medya için meta etiketleri.</p>
            @if($lastSavedFormatted)
            <span class="seo-header__saved">Son kaydedilme: {{ $lastSavedFormatted }}</span>
            @endif
        </div>
        <div class="seo-header__actions">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="seo-btn seo-btn--secondary">Önizle</a>
            <button type="submit" form="seoForm" class="seo-btn seo-btn--primary" id="seoSaveBtn" disabled>Kaydet</button>
        </div>
    </header>

    @if(session('success'))
    <div class="seo-toast seo-toast--success" id="seoToast" role="alert">
        <span class="seo-toast__icon">✓</span>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="seo-alert seo-alert--error">
        Lütfen formdaki hataları düzeltin.
    </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.seo') }}" enctype="multipart/form-data" id="seoForm">
        @csrf

        {{-- Tabs --}}
        <div class="seo-tabs" role="tablist">
            <button type="button" class="seo-tab is-active" role="tab" aria-selected="true" aria-controls="panel-basic" id="tab-basic">Temel SEO</button>
            <button type="button" class="seo-tab" role="tab" aria-selected="false" aria-controls="panel-social" id="tab-social">Sosyal Medya</button>
            <button type="button" class="seo-tab" role="tab" aria-selected="false" aria-controls="panel-verification" id="tab-verification">Doğrulama & Schema</button>
        </div>

        {{-- Tab 1: Temel SEO --}}
        <div class="seo-panel is-active" id="panel-basic" role="tabpanel" aria-labelledby="tab-basic">
            <div class="seo-grid">
                <div class="seo-main">
                    <div class="seo-card">
                        <h2 class="seo-card__title">Temel Meta</h2>
                        <div class="seo-card__body">
                            <div class="seo-field">
                                <label for="meta_title">Meta Başlık</label>
                                <input type="text" name="meta_title" id="meta_title" maxlength="60" class="seo-input"
                                    value="{{ old('meta_title', $seo_meta_title ?? '') }}"
                                    placeholder="RADYOYOL - Canlı Radyo">
                                <span class="seo-counter"><span id="titleCount">0</span>/60</span>
                                @error('meta_title')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="seo-field">
                                <label for="meta_description">Meta Açıklama</label>
                                <textarea name="meta_description" id="meta_description" rows="3" maxlength="160" class="seo-input seo-textarea"
                                    placeholder="RADYOYOL ile 7/24 canlı radyo dinleyin.">{{ old('meta_description', $seo_meta_description ?? '') }}</textarea>
                                <span class="seo-counter"><span id="descCount">0</span>/160</span>
                                @error('meta_description')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="seo-field">
                                <label for="canonical_url">Canonical URL</label>
                                <input type="url" name="canonical_url" id="canonical_url" class="seo-input"
                                    value="{{ old('canonical_url', $seo_canonical_url ?? '') }}"
                                    placeholder="https://www.radyoyol.com">
                                <span class="seo-helper">Boş bırakılırsa otomatik</span>
                                @error('canonical_url')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="seo-field">
                                <label for="meta_robots">Robots Meta</label>
                                <select name="meta_robots" id="meta_robots" class="seo-input seo-select">
                                    <option value="index,follow" {{ old('meta_robots', $seo_meta_robots ?? 'index,follow') == 'index,follow' ? 'selected' : '' }}>index, follow</option>
                                    <option value="noindex,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                                    <option value="index,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'index,nofollow' ? 'selected' : '' }}>index, nofollow</option>
                                    <option value="noindex,follow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,follow' ? 'selected' : '' }}>noindex, follow</option>
                                </select>
                            </div>
                            <div class="seo-field">
                                <label for="meta_keywords">Meta Anahtar Kelimeler</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" class="seo-input"
                                    value="{{ old('meta_keywords', $seo_meta_keywords ?? '') }}"
                                    placeholder="radyoyol, canlı radyo, online radyo (virgülle ayırın)">
                                @error('meta_keywords')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Accordion: Gelişmiş --}}
                    <div class="seo-accordion" data-accordion>
                        <button type="button" class="seo-accordion__toggle" aria-expanded="false" aria-controls="accordion-advanced" id="accordion-advanced-btn">
                            <span>Gelişmiş</span>
                            <span class="seo-accordion__chevron" aria-hidden="true">▼</span>
                        </button>
                        <div class="seo-accordion__body" id="accordion-advanced" hidden>
                            <div class="seo-field">
                                <label for="meta_author">Meta Yazar / Site Sahibi</label>
                                <input type="text" name="meta_author" id="meta_author" maxlength="100" class="seo-input"
                                    value="{{ old('meta_author', $seo_meta_author ?? '') }}"
                                    placeholder="RADYOYOL">
                                @error('meta_author')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="seo-field">
                                <label for="meta_referrer">Referrer Policy</label>
                                <select name="meta_referrer" id="meta_referrer" class="seo-input seo-select">
                                    <option value="" {{ old('meta_referrer', $seo_meta_referrer ?? '') == '' ? 'selected' : '' }}>Varsayılan</option>
                                    <option value="no-referrer" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'no-referrer' ? 'selected' : '' }}>no-referrer</option>
                                    <option value="strict-origin-when-cross-origin" {{ old('meta_referrer', $seo_meta_referrer ?? 'strict-origin-when-cross-origin') == 'strict-origin-when-cross-origin' ? 'selected' : '' }}>strict-origin-when-cross-origin</option>
                                    <option value="same-origin" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'same-origin' ? 'selected' : '' }}>same-origin</option>
                                </select>
                            </div>
                            <div class="seo-field">
                                <label for="geo_region">Hreflang / Geo Region</label>
                                <input type="text" name="geo_region" id="geo_region" maxlength="10" class="seo-input"
                                    value="{{ old('geo_region', $seo_geo_region ?? '') }}"
                                    placeholder="TR-34 (İstanbul)">
                                @error('geo_region')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="seo-field">
                                <label for="sitemap_url">Sitemap URL</label>
                                <input type="url" name="sitemap_url" id="sitemap_url" class="seo-input"
                                    value="{{ old('sitemap_url', $seo_sitemap_url ?? '') }}"
                                    placeholder="https://www.radyoyol.com/sitemap.xml">
                                @error('sitemap_url')<span class="seo-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="seo-sidebar">
                    <div class="seo-preview">
                        <div class="seo-preview__label">Google Önizleme</div>
                        <div class="seo-preview__box">
                            <div class="seo-preview__url" id="previewUrl">{{ parse_url(url('/'), PHP_URL_HOST) ?: 'radyoyol.com' }}</div>
                            <div class="seo-preview__title" id="previewTitle">{{ old('meta_title', $seo_meta_title ?? $siteName) ?: $siteName }}</div>
                            <div class="seo-preview__desc" id="previewDesc">{{ old('meta_description', $seo_meta_description ?? '') ?: 'Meta açıklama burada görünecek.' }}</div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        {{-- Tab 2: Sosyal Medya --}}
        <div class="seo-panel" id="panel-social" role="tabpanel" aria-labelledby="tab-social" hidden>
            <div class="seo-grid seo-grid--2">
                <div class="seo-card">
                    <h2 class="seo-card__title">Open Graph</h2>
                    <div class="seo-card__body">
                        <div class="seo-field">
                            <label for="og_title">OG Başlık</label>
                            <input type="text" name="og_title" id="og_title" maxlength="95" class="seo-input"
                                value="{{ old('og_title', $seo_og_title ?? '') }}"
                                placeholder="Boş bırakılırsa Meta Başlık kullanılır">
                            @error('og_title')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="og_description">OG Açıklama</label>
                            <textarea name="og_description" id="og_description" rows="3" maxlength="200" class="seo-input seo-textarea"
                                placeholder="Boş bırakılırsa Meta Açıklama kullanılır">{{ old('og_description', $seo_og_description ?? '') }}</textarea>
                            <span class="seo-counter"><span id="ogDescCount">0</span>/200</span>
                            @error('og_description')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="og_image_file">OG Görsel (1200×630 px önerilir)</label>
                            @if($seo_og_image_path ?? null)
                            <div class="seo-image-preview">
                                <img src="{{ asset('storage/' . $seo_og_image_path) }}" alt="OG" id="ogPreviewImg">
                                <label class="seo-check"><input type="checkbox" name="remove_og_image" value="1"> Mevcut görseli kaldır</label>
                            </div>
                            @else
                            <div class="seo-image-preview" id="ogPreviewWrap" style="display:none">
                                <img src="" alt="OG" id="ogPreviewImg">
                            </div>
                            @endif
                            <input type="file" name="og_image_file" id="og_image_file" accept=".png,.jpg,.jpeg" class="seo-file">
                            @error('og_image_file')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field-row">
                            <div class="seo-field">
                                <label for="og_type">OG Type</label>
                                <select name="og_type" id="og_type" class="seo-input seo-select">
                                    <option value="website" {{ old('og_type', $seo_og_type ?? 'website') == 'website' ? 'selected' : '' }}>website</option>
                                    <option value="article" {{ old('og_type', $seo_og_type ?? '') == 'article' ? 'selected' : '' }}>article</option>
                                </select>
                            </div>
                            <div class="seo-field">
                                <label for="og_locale">OG Locale</label>
                                <select name="og_locale" id="og_locale" class="seo-input seo-select">
                                    <option value="tr_TR" {{ old('og_locale', $seo_og_locale ?? 'tr_TR') == 'tr_TR' ? 'selected' : '' }}>tr_TR</option>
                                    <option value="en_US" {{ old('og_locale', $seo_og_locale ?? '') == 'en_US' ? 'selected' : '' }}>en_US</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="seo-card">
                    <h2 class="seo-card__title">Twitter Card</h2>
                    <div class="seo-card__body">
                        <div class="seo-field">
                            <label for="twitter_card">twitter:card</label>
                            <select name="twitter_card" id="twitter_card" class="seo-input seo-select">
                                <option value="summary_large_image" {{ old('twitter_card', $seo_twitter_card ?? 'summary_large_image') == 'summary_large_image' ? 'selected' : '' }}>summary_large_image</option>
                                <option value="summary" {{ old('twitter_card', $seo_twitter_card ?? '') == 'summary' ? 'selected' : '' }}>summary</option>
                                <option value="app" {{ old('twitter_card', $seo_twitter_card ?? '') == 'app' ? 'selected' : '' }}>app</option>
                            </select>
                        </div>
                        <div class="seo-field">
                            <label for="twitter_site">Twitter @Kullanıcı</label>
                            <input type="text" name="twitter_site" id="twitter_site" maxlength="50" class="seo-input"
                                value="{{ old('twitter_site', $seo_twitter_site ?? '') }}"
                                placeholder="@radyoyol">
                            @error('twitter_site')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="twitter_creator">Twitter İçerik Sahibi</label>
                            <input type="text" name="twitter_creator" id="twitter_creator" maxlength="50" class="seo-input"
                                value="{{ old('twitter_creator', $seo_twitter_creator ?? '') }}"
                                placeholder="@radyoyol">
                            @error('twitter_creator')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <p class="seo-helper">Twitter başlık ve açıklama için OG değerleri kullanılır.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab 3: Doğrulama & Schema --}}
        <div class="seo-panel" id="panel-verification" role="tabpanel" aria-labelledby="tab-verification" hidden>
            <div class="seo-grid seo-grid--2">
                <div class="seo-card">
                    <h2 class="seo-card__title">Doğrulama</h2>
                    <div class="seo-card__body">
                        <div class="seo-field">
                            <label for="google_site_verification">Google Doğrulama Kodu</label>
                            <input type="text" name="google_site_verification" id="google_site_verification" class="seo-input"
                                value="{{ old('google_site_verification', $seo_google_verification ?? '') }}"
                                placeholder="content değeri (abc123xyz...)">
                            @error('google_site_verification')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="bing_site_verification">Bing Doğrulama Kodu</label>
                            <input type="text" name="bing_site_verification" id="bing_site_verification" class="seo-input"
                                value="{{ old('bing_site_verification', $seo_bing_verification ?? '') }}"
                                placeholder="content değeri">
                            @error('bing_site_verification')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="yandex_verification">Yandex Doğrulama Kodu</label>
                            <input type="text" name="yandex_verification" id="yandex_verification" class="seo-input"
                                value="{{ old('yandex_verification', $seo_yandex_verification ?? '') }}"
                                placeholder="content değeri">
                            @error('yandex_verification')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="seo-card">
                    <h2 class="seo-card__title">Schema.org</h2>
                    <div class="seo-card__body">
                        <div class="seo-field">
                            <label for="schema_radio_station" class="seo-check-label">
                                <input type="checkbox" name="schema_radio_station" value="1" {{ old('schema_radio_station', $seo_schema_radio_station ?? true) ? 'checked' : '' }}>
                                RadioStation şeması ekle
                            </label>
                        </div>
                        <div class="seo-field">
                            <label for="schema_organization_name">Organizasyon Adı</label>
                            <input type="text" name="schema_organization_name" id="schema_organization_name" maxlength="150" class="seo-input"
                                value="{{ old('schema_organization_name', $seo_schema_org_name ?? '') }}"
                                placeholder="{{ $siteName }}">
                            @error('schema_organization_name')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="schema_organization_url">Organizasyon URL</label>
                            <input type="url" name="schema_organization_url" id="schema_organization_url" class="seo-input"
                                value="{{ old('schema_organization_url', $seo_schema_org_url ?? '') }}"
                                placeholder="{{ url('/') }}">
                            @error('schema_organization_url')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="schema_organization_logo">Logo URL</label>
                            <input type="url" name="schema_organization_logo" id="schema_organization_logo" class="seo-input"
                                value="{{ old('schema_organization_logo', $seo_schema_org_logo ?? '') }}"
                                placeholder="https://example.com/logo.png">
                            @error('schema_organization_logo')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="schema_description">Schema Açıklama</label>
                            <textarea name="schema_description" id="schema_description" rows="2" maxlength="500" class="seo-input seo-textarea"
                                placeholder="Site açıklaması">{{ old('schema_description', $seo_schema_description ?? '') }}</textarea>
                            @error('schema_description')<span class="seo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="seo-field">
                            <label for="schema_json">JSON-LD (Gelişmiş)</label>
                            <textarea name="schema_json" id="schema_json" rows="8" class="seo-input seo-textarea seo-code"
                                placeholder='{"@context":"https://schema.org",...}'>{{ old('schema_json', $seo_schema_json ?? '') }}</textarea>
                            <button type="button" class="seo-btn seo-btn--small" id="btnGenerateSchema">Varsayılanı Oluştur</button>
                            <span class="seo-helper">Boş bırakılırsa otomatik oluşturulur.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Save Bar (mobile) --}}
        <div class="seo-save-bar" id="seoSaveBar" hidden>
            <button type="submit" form="seoForm" class="seo-btn seo-btn--primary seo-btn--block">Kaydet</button>
        </div>
    </form>
</div>

@push('styles')
<style>
.seo-page { max-width: 1200px; margin: 0 auto; padding-bottom: 5rem; }
.seo-header {
    display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 1rem;
    margin-bottom: 1.5rem;
}
.seo-header__title { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0 0 0.25rem 0; }
.seo-header__subtitle { font-size: 0.9rem; color: var(--muted); margin: 0 0 0.5rem 0; }
.seo-header__saved { font-size: 0.8rem; color: var(--muted); }
.seo-header__actions { display: flex; gap: 0.75rem; flex-shrink: 0; }
.seo-btn {
    padding: 0.6rem 1.25rem; font-size: 0.9rem; font-weight: 600; border-radius: 10px;
    border: 1px solid transparent; cursor: pointer; transition: opacity 0.2s, background 0.2s;
    text-decoration: none; display: inline-flex; align-items: center; justify-content: center;
}
.seo-btn--primary { background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; }
.seo-btn--primary:hover:not(:disabled) { opacity: 0.95; }
.seo-btn--primary:disabled { opacity: 0.5; cursor: not-allowed; }
.seo-btn--secondary { background: rgba(255,255,255,0.08); color: var(--text); border-color: var(--border); }
.seo-btn--secondary:hover { background: rgba(255,255,255,0.12); }
.seo-btn--small { padding: 0.4rem 0.9rem; font-size: 0.8rem; margin-top: 0.5rem; }
.seo-btn--block { width: 100%; }
.seo-toast {
    position: fixed; top: 1rem; right: 1rem; z-index: 9999;
    padding: 1rem 1.25rem; border-radius: 10px; display: flex; align-items: center; gap: 0.5rem;
    font-size: 0.95rem; font-weight: 600; box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: seoToastIn 0.3s ease;
}
.seo-toast--success { background: rgba(34,197,94,0.95); color: #fff; }
@keyframes seoToastIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.seo-alert--error { padding: 1rem; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.seo-tabs {
    display: flex; gap: 0.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border);
}
.seo-tab {
    padding: 0.75rem 1.25rem; font-size: 0.9rem; font-weight: 600; color: var(--muted);
    background: transparent; border: none; border-bottom: 2px solid transparent;
    cursor: pointer; transition: color 0.2s, border-color 0.2s; margin-bottom: -1px;
}
.seo-tab:hover { color: var(--text); }
.seo-tab.is-active { color: var(--accent); border-bottom-color: var(--accent); }
.seo-panel { display: none; }
.seo-panel.is-active { display: block; }
.seo-grid {
    display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start;
}
.seo-grid--2 { grid-template-columns: 1fr 1fr; }
@media (max-width: 900px) {
    .seo-grid { grid-template-columns: 1fr; }
    .seo-grid--2 { grid-template-columns: 1fr; }
    .seo-sidebar { order: -1; }
}
.seo-card {
    background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 1rem;
}
.seo-card__title { font-size: 0.95rem; font-weight: 700; padding: 1rem 1.25rem; margin: 0; background: rgba(0,0,0,0.2); border-bottom: 1px solid var(--border); color: #fff; }
.seo-card__body { padding: 1.25rem; }
.seo-field { margin-bottom: 1.25rem; }
.seo-field:last-child { margin-bottom: 0; }
.seo-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.seo-field label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 0.4rem; }
.seo-input, .seo-select, .seo-textarea {
    width: 100%; padding: 0.6rem 0.9rem; font-size: 0.9rem;
    background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 8px;
    color: var(--text); transition: border-color 0.2s;
}
.seo-input:focus, .seo-select:focus, .seo-textarea:focus { outline: none; border-color: var(--accent); }
.seo-textarea { min-height: 80px; resize: vertical; }
.seo-code { font-family: ui-monospace, monospace; font-size: 0.8rem; }
.seo-counter { font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem; display: block; }
.seo-helper { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; display: block; }
.seo-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; display: block; }
.seo-file { margin-top: 0.5rem; font-size: 0.85rem; color: var(--muted); }
.seo-check-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 500; }
.seo-check { font-size: 0.85rem; color: var(--muted); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.seo-image-preview { margin-bottom: 0.75rem; }
.seo-image-preview img { max-height: 140px; border-radius: 8px; border: 1px solid var(--border); display: block; }
.seo-accordion { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 1rem; }
.seo-accordion__toggle {
    width: 100%; padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between;
    background: rgba(0,0,0,0.2); border: none; cursor: pointer; color: var(--text); font-size: 0.95rem; font-weight: 600; text-align: left;
}
.seo-accordion__toggle:hover { background: rgba(0,0,0,0.25); }
.seo-accordion__chevron { font-size: 0.7rem; opacity: 0.8; transition: transform 0.2s; }
.seo-accordion.is-open .seo-accordion__chevron { transform: rotate(180deg); }
.seo-accordion__body { padding: 1.25rem; border-top: 1px solid var(--border); }
.seo-preview { position: sticky; top: 1rem; }
.seo-preview__label { font-size: 0.8rem; font-weight: 600; color: var(--muted); margin-bottom: 0.5rem; }
.seo-preview__box {
    background: #1a1a1a; border: 1px solid var(--border); border-radius: 8px; padding: 1rem;
    font-family: Arial, sans-serif;
}
.seo-preview__url { font-size: 0.75rem; color: #689d6a; margin-bottom: 0.25rem; }
.seo-preview__title { font-size: 1rem; color: #1d99f3; margin-bottom: 0.35rem; line-height: 1.3; }
.seo-preview__desc { font-size: 0.8rem; color: #928374; line-height: 1.4; }
.seo-save-bar {
    position: fixed; bottom: 0; left: 0; right: 0; padding: 1rem 1.5rem;
    background: var(--panel); border-top: 1px solid var(--border); z-index: 100;
    display: none;
}
@media (max-width: 768px) {
    .seo-save-bar:not([hidden]) { display: block; }
}
</style>
@endpush

@push('scripts')
<script>
(function() {
    var form = document.getElementById('seoForm');
    if (!form) return;
    var saveBtn = document.getElementById('seoSaveBtn');
    var saveBar = document.getElementById('seoSaveBar');
    var initialData = '';
    var toast = document.getElementById('seoToast');

    function getFormData() {
        var fd = new FormData(form);
        var o = {};
        for (var p of fd.entries()) {
            o[p[0]] = p[1] instanceof File ? p[1].name + ':' + p[1].size : p[1];
        }
        form.querySelectorAll('input, textarea, select').forEach(function(inp) {
            if (!inp.name) return;
            if (inp.name in o) return;
            if (inp.type === 'checkbox') o[inp.name] = inp.checked ? inp.value : '';
            else o[inp.name] = inp.value || '';
        });
        return JSON.stringify(o);
    }

    function captureInitial() {
        initialData = getFormData();
    }

    function hasChanges() {
        return getFormData() !== initialData;
    }

    function updateSaveState() {
        var changed = hasChanges();
        if (saveBtn) saveBtn.disabled = !changed;
        if (saveBar) {
            saveBar.hidden = !changed;
        }
    }

    form.querySelectorAll('input, textarea, select').forEach(function(el) {
        el.addEventListener('input', updateSaveState);
        el.addEventListener('change', updateSaveState);
    });
    captureInitial();
    updateSaveState();

    if (toast) {
        setTimeout(function() { toast.style.display = 'none'; }, 4000);
    }

    var tabs = document.querySelectorAll('.seo-tab');
    var panels = document.querySelectorAll('.seo-panel');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('is-active'); t.setAttribute('aria-selected', 'false'); });
            panels.forEach(function(p) { p.classList.remove('is-active'); p.hidden = true; });
            tab.classList.add('is-active');
            tab.setAttribute('aria-selected', 'true');
            var id = tab.getAttribute('aria-controls');
            var panel = document.getElementById(id);
            if (panel) { panel.classList.add('is-active'); panel.hidden = false; }
        });
    });

    var accordion = document.querySelector('[data-accordion]');
    if (accordion) {
        var toggle = accordion.querySelector('.seo-accordion__toggle');
        var body = accordion.querySelector('.seo-accordion__body');
        toggle.addEventListener('click', function() {
            var open = accordion.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open);
            body.hidden = !open;
        });
    }

    function setCount(id, inpId) {
        var inp = document.getElementById(inpId);
        var el = document.getElementById(id);
        if (!inp || !el) return;
        function upd() { el.textContent = inp.value.length; }
        upd();
        inp.addEventListener('input', upd);
    }
    setCount('titleCount', 'meta_title', 60);
    setCount('descCount', 'meta_description', 160);
    setCount('ogDescCount', 'og_description', 200);

    var titleInp = document.getElementById('meta_title');
    var descInp = document.getElementById('meta_description');
    var previewTitle = document.getElementById('previewTitle');
    var previewDesc = document.getElementById('previewDesc');
    var previewUrl = document.getElementById('previewUrl');
    function updatePreview() {
        if (previewTitle) previewTitle.textContent = titleInp && titleInp.value ? titleInp.value : 'Meta Başlık';
        if (previewDesc) previewDesc.textContent = descInp && descInp.value ? descInp.value : 'Meta açıklama burada görünecek.';
        if (previewUrl) previewUrl.textContent = window.location.hostname || 'radyoyol.com';
    }
    if (titleInp) titleInp.addEventListener('input', updatePreview);
    if (descInp) descInp.addEventListener('input', updatePreview);
    updatePreview();

    var ogFile = document.getElementById('og_image_file');
    var ogPreview = document.getElementById('ogPreviewImg');
    var ogWrap = document.getElementById('ogPreviewWrap');
    if (ogFile && (ogPreview || ogWrap)) {
        ogFile.addEventListener('change', function() {
            var f = ogFile.files[0];
            if (f && /^image\//.test(f.type)) {
                var r = new FileReader();
                r.onload = function() {
                    if (ogPreview) ogPreview.src = r.result;
                    if (ogWrap) { ogWrap.style.display = 'block'; }
                };
                r.readAsDataURL(f);
            }
        });
    }

    var btnSchema = document.getElementById('btnGenerateSchema');
    var schemaJson = document.getElementById('schema_json');
    var schemaName = document.getElementById('schema_organization_name');
    var schemaUrl = document.getElementById('schema_organization_url');
    var schemaLogo = document.getElementById('schema_organization_logo');
    var schemaDesc = document.getElementById('schema_description');
    if (btnSchema && schemaJson) {
        btnSchema.addEventListener('click', function() {
            var name = (schemaName && schemaName.value) || {!! json_encode($siteName) !!};
            var url = (schemaUrl && schemaUrl.value) || {!! json_encode(url('/')) !!};
            var logo = schemaLogo && schemaLogo.value ? schemaLogo.value : '';
            var desc = schemaDesc && schemaDesc.value ? schemaDesc.value : '';
            var org = { '@type': 'Organization', name: name, url: url };
            if (logo) org.logo = logo;
            if (desc) org.description = desc;
            var website = { '@type': 'WebSite', name: name, url: url };
            if (desc) website.description = desc;
            var radio = { '@type': 'RadioStation', name: name, url: url };
            if (desc) radio.description = desc;
            var graph = [org, website, radio];
            var ld = { '@context': 'https://schema.org', '@graph': graph };
            schemaJson.value = JSON.stringify(ld, null, 2);
            updateSaveState();
        });
    }

    form.addEventListener('submit', function() {
        if (saveBtn) saveBtn.disabled = true;
    });
})();
</script>
@endpush
@endsection
