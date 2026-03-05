@extends('admin.layouts.app')

@section('content')
<div class="seo-settings-page">
    <div class="settings-page-header">
        <h1 class="settings-page-title">SEO Ayarları</h1>
        <p class="settings-page-desc">Arama motorları ve sosyal medya için meta etiketleri.</p>
    </div>

    @if(session('success'))
        <div class="settings-success">
            <span class="settings-success-icon">✓</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="settings-error">
            <span class="settings-error-icon">!</span>
            Lütfen formdaki hataları düzeltin.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.seo') }}" enctype="multipart/form-data" class="seo-settings-form">
        @csrf

        {{-- Temel Meta --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Temel Meta</h2>
                <p class="settings-section-desc">Google ve arama motorlarında görünen bilgiler</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="meta_title">Meta Başlık (max 60 karakter)</label>
                    <input type="text" name="meta_title" id="meta_title" maxlength="60"
                        value="{{ old('meta_title', $seo_meta_title ?? '') }}"
                        placeholder="RADYOYOL - Canlı Radyo"
                        class="form-input">
                    <span class="form-hint"><span id="titleCount">0</span>/60</span>
                    @error('meta_title')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Açıklama (max 160 karakter)</label>
                    <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                        placeholder="RADYOYOL ile 7/24 canlı radyo dinleyin."
                        class="form-input form-textarea">{{ old('meta_description', $seo_meta_description ?? '') }}</textarea>
                    <span class="form-hint"><span id="descCount">0</span>/160</span>
                    @error('meta_description')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Meta Anahtar Kelimeler</label>
                    <input type="text" name="meta_keywords" id="meta_keywords"
                        value="{{ old('meta_keywords', $seo_meta_keywords ?? '') }}"
                        placeholder="radyoyol, canlı radyo, online radyo"
                        class="form-input">
                    @error('meta_keywords')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="meta_robots">Robots Meta</label>
                    <select name="meta_robots" id="meta_robots" class="form-input">
                        <option value="index,follow" {{ old('meta_robots', $seo_meta_robots ?? 'index,follow') == 'index,follow' ? 'selected' : '' }}>index, follow</option>
                        <option value="noindex,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                        <option value="index,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'index,nofollow' ? 'selected' : '' }}>index, nofollow</option>
                        <option value="noindex,follow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,follow' ? 'selected' : '' }}>noindex, follow</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="canonical_url">Canonical URL</label>
                    <input type="url" name="canonical_url" id="canonical_url"
                        value="{{ old('canonical_url', $seo_canonical_url ?? '') }}"
                        placeholder="Boş bırakılırsa otomatik"
                        class="form-input">
                    @error('canonical_url')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="meta_author">Meta Yazar</label>
                    <input type="text" name="meta_author" id="meta_author"
                        value="{{ old('meta_author', $seo_meta_author ?? '') }}"
                        placeholder="RADYOYOL"
                        class="form-input">
                    @error('meta_author')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </section>

        {{-- Open Graph --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Open Graph (Facebook, WhatsApp)</h2>
                <p class="settings-section-desc">Sosyal medyada paylaşım önizlemesi</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="og_title">OG Başlık</label>
                    <input type="text" name="og_title" id="og_title"
                        value="{{ old('og_title', $seo_og_title ?? '') }}"
                        placeholder="Boş bırakılırsa Meta Başlık kullanılır"
                        class="form-input">
                    @error('og_title')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="og_description">OG Açıklama</label>
                    <textarea name="og_description" id="og_description" rows="2"
                        placeholder="Boş bırakılırsa Meta Açıklama kullanılır"
                        class="form-input form-textarea">{{ old('og_description', $seo_og_description ?? '') }}</textarea>
                    @error('og_description')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="og_image_file">OG Görsel (1200×630 px önerilir)</label>
                    @if($seo_og_image_path ?? null)
                        <div class="seo-image-current">
                            <img src="{{ asset('storage/' . $seo_og_image_path) }}" alt="OG" style="max-height:120px;border-radius:8px;">
                            <label class="form-check"><input type="checkbox" name="remove_og_image" value="1"> Mevcut görseli kaldır</label>
                        </div>
                    @endif
                    <input type="file" name="og_image_file" id="og_image_file" accept=".png,.jpg,.jpeg" class="form-input">
                    @error('og_image_file')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="og_type">OG Type</label>
                        <select name="og_type" id="og_type" class="form-input">
                            <option value="website" {{ old('og_type', $seo_og_type ?? 'website') == 'website' ? 'selected' : '' }}>website</option>
                            <option value="article" {{ old('og_type', $seo_og_type ?? '') == 'article' ? 'selected' : '' }}>article</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="og_locale">OG Locale</label>
                        <select name="og_locale" id="og_locale" class="form-input">
                            <option value="tr_TR" {{ old('og_locale', $seo_og_locale ?? 'tr_TR') == 'tr_TR' ? 'selected' : '' }}>tr_TR</option>
                            <option value="en_US" {{ old('og_locale', $seo_og_locale ?? '') == 'en_US' ? 'selected' : '' }}>en_US</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        {{-- Twitter Card --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Twitter Card</h2>
                <p class="settings-section-desc">Twitter/X paylaşım kartı</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="twitter_card">twitter:card</label>
                    <select name="twitter_card" id="twitter_card" class="form-input">
                        <option value="summary_large_image" {{ old('twitter_card', $seo_twitter_card ?? 'summary_large_image') == 'summary_large_image' ? 'selected' : '' }}>summary_large_image</option>
                        <option value="summary" {{ old('twitter_card', $seo_twitter_card ?? '') == 'summary' ? 'selected' : '' }}>summary</option>
                    </select>
                </div>
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="twitter_site">Twitter @Kullanıcı</label>
                        <input type="text" name="twitter_site" id="twitter_site"
                            value="{{ old('twitter_site', $seo_twitter_site ?? '') }}"
                            placeholder="@radyoyol"
                            class="form-input">
                        @error('twitter_site')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="twitter_creator">Twitter İçerik Sahibi</label>
                        <input type="text" name="twitter_creator" id="twitter_creator"
                            value="{{ old('twitter_creator', $seo_twitter_creator ?? '') }}"
                            placeholder="@radyoyol"
                            class="form-input">
                        @error('twitter_creator')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </section>

        {{-- Doğrulama --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Arama Motoru Doğrulama</h2>
                <p class="settings-section-desc">Search Console ve Webmaster araçları</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="google_site_verification">Google Doğrulama Kodu</label>
                    <input type="text" name="google_site_verification" id="google_site_verification"
                        value="{{ old('google_site_verification', $seo_google_verification ?? '') }}"
                        placeholder="content değeri"
                        class="form-input">
                    @error('google_site_verification')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="bing_site_verification">Bing Doğrulama Kodu</label>
                    <input type="text" name="bing_site_verification" id="bing_site_verification"
                        value="{{ old('bing_site_verification', $seo_bing_verification ?? '') }}"
                        placeholder="content değeri"
                        class="form-input">
                    @error('bing_site_verification')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="yandex_verification">Yandex Doğrulama Kodu</label>
                    <input type="text" name="yandex_verification" id="yandex_verification"
                        value="{{ old('yandex_verification', $seo_yandex_verification ?? '') }}"
                        placeholder="content değeri"
                        class="form-input">
                    @error('yandex_verification')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </section>

        {{-- Schema.org --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Schema.org (JSON-LD)</h2>
                <p class="settings-section-desc">Zengin sonuçlar için yapısal veri</p>
            </div>
            <div class="settings-section-body">
                <label class="settings-toggle">
                    <input type="checkbox" name="schema_radio_station" value="1"
                        {{ old('schema_radio_station', $seo_schema_radio_station ?? true) ? 'checked' : '' }}
                        class="settings-toggle-input">
                    <span class="settings-toggle-slider"></span>
                    <span class="settings-toggle-label">RadioStation şeması ekle</span>
                </label>
                <div class="form-group">
                    <label for="schema_organization_name">Organizasyon Adı</label>
                    <input type="text" name="schema_organization_name" id="schema_organization_name"
                        value="{{ old('schema_organization_name', $seo_schema_org_name ?? '') }}"
                        placeholder="{{ $site_name ?? 'RADYOYOL' }}"
                        class="form-input">
                    @error('schema_organization_name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="schema_organization_url">Organizasyon URL</label>
                    <input type="url" name="schema_organization_url" id="schema_organization_url"
                        value="{{ old('schema_organization_url', $seo_schema_org_url ?? '') }}"
                        placeholder="{{ url('/') }}"
                        class="form-input">
                    @error('schema_organization_url')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="schema_organization_logo">Logo URL</label>
                    <input type="url" name="schema_organization_logo" id="schema_organization_logo"
                        value="{{ old('schema_organization_logo', $seo_schema_org_logo ?? '') }}"
                        placeholder="https://example.com/logo.png"
                        class="form-input">
                    @error('schema_organization_logo')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="schema_description">Schema Açıklama</label>
                    <textarea name="schema_description" id="schema_description" rows="2"
                        placeholder="Site açıklaması"
                        class="form-input form-textarea">{{ old('schema_description', $seo_schema_description ?? '') }}</textarea>
                    @error('schema_description')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </section>

        {{-- Ek Ayarlar --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Ek Ayarlar</h2>
                <p class="settings-section-desc">Sitemap, referrer ve bölge</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="sitemap_url">Sitemap URL</label>
                    <input type="url" name="sitemap_url" id="sitemap_url"
                        value="{{ old('sitemap_url', $seo_sitemap_url ?? '') }}"
                        placeholder="https://example.com/sitemap.xml"
                        class="form-input">
                    @error('sitemap_url')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="geo_region">Geo Region</label>
                        <input type="text" name="geo_region" id="geo_region"
                            value="{{ old('geo_region', $seo_geo_region ?? '') }}"
                            placeholder="TR-34"
                            class="form-input">
                        @error('geo_region')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="meta_referrer">Referrer Policy</label>
                        <select name="meta_referrer" id="meta_referrer" class="form-input">
                            <option value="" {{ old('meta_referrer', $seo_meta_referrer ?? '') == '' ? 'selected' : '' }}>Varsayılan</option>
                            <option value="no-referrer" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'no-referrer' ? 'selected' : '' }}>no-referrer</option>
                            <option value="strict-origin-when-cross-origin" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'strict-origin-when-cross-origin' ? 'selected' : '' }}>strict-origin-when-cross-origin</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <span class="btn-save-icon">✓</span>
                Kaydet
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
.seo-settings-page { max-width: 720px; }
.seo-image-current { margin-bottom: 0.75rem; }
.seo-image-current img { display: block; margin-bottom: 0.5rem; }
.form-hint { font-size: 0.8rem; color: #8b95a5; margin-top: 0.25rem; display: block; }
.form-check { font-size: 0.85rem; color: #8b95a5; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 0.5rem; }
.seo-settings-page .settings-section,
.seo-settings-page .settings-page-header,
.seo-settings-page .form-actions { margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; }
.seo-settings-page .form-actions { padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08); margin-top: 0; }
.seo-settings-page .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media (max-width: 600px) { .seo-settings-page .form-row-2 { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script>
(function() {
    function cnt(id, inpId) {
        var el = document.getElementById(id), inp = document.getElementById(inpId);
        if (!el || !inp) return;
        el.textContent = inp.value.length;
        inp.addEventListener('input', function() { el.textContent = inp.value.length; });
    }
    cnt('titleCount', 'meta_title');
    cnt('descCount', 'meta_description');
})();
</script>
@endpush
@endsection
