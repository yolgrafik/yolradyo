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
                <div class="form-group">
                    <label for="schema_json">Özel JSON-LD (boş bırakılırsa otomatik oluşturulur)</label>
                    @php
                        $schemaJsonValue = old('schema_json');
                        if ($schemaJsonValue === null) {
                            $schemaJsonValue = is_string($seo_schema_json ?? null) ? $seo_schema_json : (is_array($seo_schema_json ?? null) ? json_encode($seo_schema_json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '');
                        }
                    @endphp
                    <textarea name="schema_json" id="schema_json" rows="6"
                        placeholder='{"@@context":"https://schema.org","@@graph":[...]}'
                        class="form-input form-textarea font-mono">{{ $schemaJsonValue }}</textarea>
                    <span class="form-hint">Geçerli JSON-LD. Boş bırakılırsa Organization, WebSite ve RadioStation şemaları otomatik eklenir.</span>
                    @error('schema_json')<span class="form-error">{{ $message }}</span>@enderror
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
.seo-settings-page .settings-page-header { margin-bottom: 1.75rem; }
.seo-settings-page .settings-page-title { font-size: 1.5rem; font-weight: 700; color: #f0f2f5; margin-bottom: 0.35rem; }
.seo-settings-page .settings-page-desc { font-size: 0.95rem; color: #8b95a5; }
.settings-success { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.35); border-radius: 12px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.5rem; }
.settings-success-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: rgba(34,197,94,0.4); border-radius: 50%; font-size: 0.75rem; font-weight: 700; }
.settings-error { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.35); border-radius: 12px; color: #fca5a5; font-size: 0.9rem; margin-bottom: 1.5rem; }
.settings-error-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.4); border-radius: 50%; font-size: 0.75rem; font-weight: 700; }
.seo-settings-page .settings-section { margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; }
.seo-settings-page .settings-section-header { margin-bottom: 1.25rem; }
.seo-settings-page .settings-section-title { font-size: 1.1rem; font-weight: 700; color: #e5e7eb; margin-bottom: 0.25rem; }
.seo-settings-page .settings-section-desc { font-size: 0.85rem; color: #8b95a5; }
.seo-settings-page .settings-section-body { display: flex; flex-direction: column; gap: 1.25rem; }
.seo-settings-page .form-group { margin: 0; }
.seo-settings-page .form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: #d1d5db; margin-bottom: 0.5rem; }
.seo-settings-page .form-input { width: 100%; padding: 0.7rem 1rem; font-size: 0.95rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 10px; color: #f0f2f5; }
.seo-settings-page .form-input:focus { outline: none; border-color: var(--accent); }
.seo-settings-page .form-textarea { resize: vertical; min-height: 88px; }
.seo-settings-page .font-mono { font-family: ui-monospace, monospace; font-size: 0.85rem; }
.seo-settings-page .form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.4rem; display: block; }
.seo-settings-page .form-hint { font-size: 0.8rem; color: #8b95a5; margin-top: 0.25rem; display: block; }
.seo-settings-page .form-check { font-size: 0.85rem; color: #8b95a5; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 0.5rem; }
.seo-settings-page .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.seo-settings-page .form-actions { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08); }
.seo-settings-page .btn-save { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.seo-image-current { margin-bottom: 0.75rem; }
.seo-image-current img { display: block; margin-bottom: 0.5rem; }
.settings-toggle { display: flex; align-items: center; gap: 1rem; cursor: pointer; margin-bottom: 1rem; }
.settings-toggle-input { position: absolute; opacity: 0; width: 0; height: 0; }
.settings-toggle-slider { width: 48px; height: 26px; background: rgba(255,255,255,0.1); border-radius: 13px; transition: background 0.2s; flex-shrink: 0; position: relative; }
.settings-toggle-slider::before { content: ''; position: absolute; width: 20px; height: 20px; left: 3px; top: 3px; background: #9ca3af; border-radius: 50%; transition: transform 0.2s; }
.settings-toggle-input:checked + .settings-toggle-slider { background: rgba(234,179,8,0.4); }
.settings-toggle-input:checked + .settings-toggle-slider::before { transform: translateX(22px); background: #fbbf24; }
.settings-toggle-label { font-size: 0.95rem; font-weight: 600; color: #e5e7eb; }
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
