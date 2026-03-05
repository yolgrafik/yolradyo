@extends('admin.layouts.app')

@section('content')
<div class="seo-settings">
    <div class="seo-header">
        <h1 class="seo-title">SEO Ayarları</h1>
        <p class="seo-desc">Arama motorları ve sosyal medya paylaşımları için en üst düzey meta etiketleri, Open Graph, Twitter Card ve Schema.org ayarlarını yapılandırın.</p>
    </div>

    @if(session('success'))
        <div class="settings-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.seo') }}" enctype="multipart/form-data" id="seoForm">
        @csrf

        {{-- 1. TEMEL META ETİKETLERİ --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="basic">
                <span class="seo-section__icon">📌</span>
                <span class="seo-section__title">Temel Meta Etiketleri</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-basic">
                <p class="seo-section__help">Google ve diğer arama motorlarında görünen temel bilgiler.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="meta_title">Meta Başlık <span class="req">*</span></label>
                        <input type="text" name="meta_title" id="meta_title" maxlength="70"
                            value="{{ old('meta_title', $seo_meta_title ?? '') }}"
                            placeholder="RADYOYOL - Canlı Radyo | Online Dinle">
                        <span class="char-count"><span id="titleCount">0</span>/70</span>
                        @error('meta_title')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="meta_description">Meta Açıklama <span class="req">*</span></label>
                        <textarea name="meta_description" id="meta_description" rows="4" maxlength="160"
                            placeholder="RADYOYOL ile 7/24 canlı radyo dinleyin. En güncel müzikler, haberler ve eğlence tek tıkla sizde.">{{ old('meta_description', $seo_meta_description ?? '') }}</textarea>
                        <span class="char-count"><span id="descCount">0</span>/160</span>
                        @error('meta_description')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="meta_keywords">Meta Anahtar Kelimeler</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" maxlength="500"
                            value="{{ old('meta_keywords', $seo_meta_keywords ?? '') }}"
                            placeholder="radyoyol, canlı radyo, online radyo, internet radyo, türkçe radyo, müzik radyo">
                        <span class="char-count"><span id="keywordsCount">0</span>/500</span>
                        @error('meta_keywords')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row form-row--2">
                    <div class="form-group">
                        <label for="meta_author">Meta Yazar / Sahip</label>
                        <input type="text" name="meta_author" id="meta_author" maxlength="100"
                            value="{{ old('meta_author', $seo_meta_author ?? '') }}"
                            placeholder="RADYOYOL">
                        @error('meta_author')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="meta_robots">Robots Meta</label>
                        <select name="meta_robots" id="meta_robots">
                            <option value="index,follow" {{ old('meta_robots', $seo_meta_robots ?? 'index,follow') == 'index,follow' ? 'selected' : '' }}>index, follow (Önerilen)</option>
                            <option value="noindex,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                            <option value="index,nofollow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'index,nofollow' ? 'selected' : '' }}>index, nofollow</option>
                            <option value="noindex,follow" {{ old('meta_robots', $seo_meta_robots ?? '') == 'noindex,follow' ? 'selected' : '' }}>noindex, follow</option>
                        </select>
                        @error('meta_robots')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="canonical_url">Canonical URL (Boş bırakılırsa otomatik)</label>
                        <input type="url" name="canonical_url" id="canonical_url"
                            value="{{ old('canonical_url', $seo_canonical_url ?? '') }}"
                            placeholder="https://www.radyoyol.com">
                        @error('canonical_url')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. OPEN GRAPH (Facebook, LinkedIn) --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="og">
                <span class="seo-section__icon">📱</span>
                <span class="seo-section__title">Open Graph (Facebook, LinkedIn, WhatsApp)</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-og">
                <p class="seo-section__help">Sosyal medyada paylaşıldığında görünen önizleme kartı bilgileri.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="og_title">OG Başlık</label>
                        <input type="text" name="og_title" id="og_title" maxlength="95"
                            value="{{ old('og_title', $seo_og_title ?? '') }}"
                            placeholder="Boş bırakılırsa Meta Başlık kullanılır">
                        @error('og_title')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="og_description">OG Açıklama</label>
                        <textarea name="og_description" id="og_description" rows="3" maxlength="200"
                            placeholder="Boş bırakılırsa Meta Açıklama kullanılır">{{ old('og_description', $seo_og_description ?? '') }}</textarea>
                        <span class="char-count"><span id="ogDescCount">0</span>/200</span>
                        @error('og_description')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="og_image_file">OG Görsel (Önerilen: 1200×630 px, PNG/JPG - max 2MB)</label>
                        @if($seo_og_image_path ?? null)
                            <div class="current-og-image">
                                <img src="{{ asset('storage/' . $seo_og_image_path) }}" alt="OG">
                                <label class="remove-check"><input type="checkbox" name="remove_og_image" value="1"> Mevcut görseli kaldır</label>
                            </div>
                        @endif
                        <input type="file" name="og_image_file" id="og_image_file" accept=".png,.jpg,.jpeg">
                        @error('og_image_file')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row form-row--2">
                    <div class="form-group">
                        <label for="og_type">OG Type</label>
                        <select name="og_type" id="og_type">
                            <option value="website" {{ old('og_type', $seo_og_type ?? 'website') == 'website' ? 'selected' : '' }}>website</option>
                            <option value="article" {{ old('og_type', $seo_og_type ?? '') == 'article' ? 'selected' : '' }}>article</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="og_locale">OG Locale</label>
                        <select name="og_locale" id="og_locale">
                            <option value="tr_TR" {{ old('og_locale', $seo_og_locale ?? 'tr_TR') == 'tr_TR' ? 'selected' : '' }}>tr_TR (Türkçe)</option>
                            <option value="en_US" {{ old('og_locale', $seo_og_locale ?? '') == 'en_US' ? 'selected' : '' }}>en_US</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. TWITTER CARD --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="twitter">
                <span class="seo-section__icon">🐦</span>
                <span class="seo-section__title">Twitter Card (X)</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-twitter">
                <p class="seo-section__help">Twitter/X paylaşımlarında görünen kart ayarları.</p>

                <div class="form-row form-row--2">
                    <div class="form-group">
                        <label for="twitter_card">Twitter Card Tipi</label>
                        <select name="twitter_card" id="twitter_card">
                            <option value="summary_large_image" {{ old('twitter_card', $seo_twitter_card ?? 'summary_large_image') == 'summary_large_image' ? 'selected' : '' }}>summary_large_image (Önerilen)</option>
                            <option value="summary" {{ old('twitter_card', $seo_twitter_card ?? '') == 'summary' ? 'selected' : '' }}>summary</option>
                            <option value="app" {{ old('twitter_card', $seo_twitter_card ?? '') == 'app' ? 'selected' : '' }}>app</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="twitter_site">Twitter @Kullanıcı (örn: @radyoyol)</label>
                        <input type="text" name="twitter_site" id="twitter_site" maxlength="50"
                            value="{{ old('twitter_site', $seo_twitter_site ?? '') }}"
                            placeholder="@radyoyol">
                        @error('twitter_site')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="twitter_creator">Twitter İçerik Sahibi @Kullanıcı</label>
                        <input type="text" name="twitter_creator" id="twitter_creator" maxlength="50"
                            value="{{ old('twitter_creator', $seo_twitter_creator ?? '') }}"
                            placeholder="@radyoyol">
                        @error('twitter_creator')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. ARAMA MOTORU DOĞRULAMA --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="verification">
                <span class="seo-section__icon">✓</span>
                <span class="seo-section__title">Arama Motoru Doğrulama Kodları</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-verification">
                <p class="seo-section__help">Google Search Console, Bing Webmaster ve Yandex doğrulama meta etiketleri.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="google_site_verification">Google Site Verification (content değeri)</label>
                        <input type="text" name="google_site_verification" id="google_site_verification"
                            value="{{ old('google_site_verification', $seo_google_verification ?? '') }}"
                            placeholder="abc123xyz...">
                        @error('google_site_verification')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="bing_site_verification">Bing / Microsoft Site Verification</label>
                        <input type="text" name="bing_site_verification" id="bing_site_verification"
                            value="{{ old('bing_site_verification', $seo_bing_verification ?? '') }}"
                            placeholder="abc123xyz...">
                        @error('bing_site_verification')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="yandex_verification">Yandex Verification</label>
                        <input type="text" name="yandex_verification" id="yandex_verification"
                            value="{{ old('yandex_verification', $seo_yandex_verification ?? '') }}"
                            placeholder="abc123xyz...">
                        @error('yandex_verification')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. SCHEMA.ORG / YAPISAL VERİ --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="schema">
                <span class="seo-section__icon">📋</span>
                <span class="seo-section__title">Schema.org (Yapısal Veri / JSON-LD)</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-schema">
                <p class="seo-section__help">Google zengin sonuçlar için Organization ve WebSite şeması.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="schema_organization_name">Organizasyon Adı</label>
                        <input type="text" name="schema_organization_name" id="schema_organization_name" maxlength="150"
                            value="{{ old('schema_organization_name', $seo_schema_org_name ?? '') }}"
                            placeholder="RADYOYOL">
                        @error('schema_organization_name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row form-row--2">
                    <div class="form-group">
                        <label for="schema_organization_url">Organizasyon URL</label>
                        <input type="url" name="schema_organization_url" id="schema_organization_url"
                            value="{{ old('schema_organization_url', $seo_schema_org_url ?? '') }}"
                            placeholder="https://www.radyoyol.com">
                        @error('schema_organization_url')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="schema_organization_logo">Organizasyon Logo URL</label>
                        <input type="url" name="schema_organization_logo" id="schema_organization_logo"
                            value="{{ old('schema_organization_logo', $seo_schema_org_logo ?? '') }}"
                            placeholder="https://www.radyoyol.com/logo.png">
                        @error('schema_organization_logo')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="schema_description">Schema Açıklama</label>
                        <textarea name="schema_description" id="schema_description" rows="3" maxlength="500"
                            placeholder="RADYOYOL - Canlı radyo dinleme platformu">{{ old('schema_description', $seo_schema_description ?? '') }}</textarea>
                        <span class="char-count"><span id="schemaDescCount">0</span>/500</span>
                        @error('schema_description')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="schema_radio_station" value="1" {{ old('schema_radio_station', $seo_schema_radio_station ?? true) ? 'checked' : '' }}>
                            RadioStation şeması ekle (radyo için özel zengin sonuçlar)
                        </label>
                        @error('schema_radio_station')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. EK AYARLAR --}}
        <div class="seo-section">
            <button type="button" class="seo-section__toggle" data-section="extra">
                <span class="seo-section__icon">⚙</span>
                <span class="seo-section__title">Ek Ayarlar</span>
                <span class="seo-section__chevron">▼</span>
            </button>
            <div class="seo-section__body" id="section-extra">
                <p class="seo-section__help">Sitemap, robots ve diğer meta etiketleri.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sitemap_url">Sitemap URL</label>
                        <input type="url" name="sitemap_url" id="sitemap_url"
                            value="{{ old('sitemap_url', $seo_sitemap_url ?? '') }}"
                            placeholder="https://www.radyoyol.com/sitemap.xml">
                        @error('sitemap_url')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="geo_region">Geo Region (ISO 3166-2)</label>
                        <input type="text" name="geo_region" id="geo_region" maxlength="10"
                            value="{{ old('geo_region', $seo_geo_region ?? '') }}"
                            placeholder="TR-34 (İstanbul)">
                        @error('geo_region')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="meta_referrer">Referrer Policy</label>
                        <select name="meta_referrer" id="meta_referrer">
                            <option value="" {{ old('meta_referrer', $seo_meta_referrer ?? '') == '' ? 'selected' : '' }}>Varsayılan</option>
                            <option value="no-referrer" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'no-referrer' ? 'selected' : '' }}>no-referrer</option>
                            <option value="strict-origin-when-cross-origin" {{ old('meta_referrer', $seo_meta_referrer ?? 'strict-origin-when-cross-origin') == 'strict-origin-when-cross-origin' ? 'selected' : '' }}>strict-origin-when-cross-origin</option>
                            <option value="same-origin" {{ old('meta_referrer', $seo_meta_referrer ?? '') == 'same-origin' ? 'selected' : '' }}>same-origin</option>
                        </select>
                        @error('meta_referrer')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Tüm SEO Ayarlarını Kaydet</button>
        </div>
    </form>
</div>

@push('styles')
<style>
.seo-settings { max-width: 900px; }
.seo-header { margin-bottom: 2rem; }
.seo-title { font-size: 1.75rem; font-weight: 700; color: white; margin-bottom: 0.5rem; }
.seo-desc { font-size: 0.95rem; color: var(--muted); line-height: 1.5; }
.settings-success { padding: 1rem 1.25rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 12px; color: #86efac; font-size: 0.95rem; margin-bottom: 1.5rem; font-weight: 600; }
.seo-section { background: var(--card); border-radius: 14px; overflow: hidden; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.08); }
.seo-section__toggle { width: 100%; display: flex; align-items: center; gap: 12px; padding: 1rem 1.25rem; background: rgba(0,0,0,0.2); border: none; cursor: pointer; color: white; font-size: 1rem; font-weight: 600; text-align: left; transition: background 0.2s; }
.seo-section__toggle:hover { background: rgba(0,0,0,0.25); }
.seo-section__icon { font-size: 1.25rem; }
.seo-section__chevron { margin-left: auto; font-size: 0.75rem; opacity: 0.8; transition: transform 0.2s; }
.seo-section.is-open .seo-section__chevron { transform: rotate(180deg); }
.seo-section__body { padding: 1.25rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.06); display: none; }
.seo-section.is-open .seo-section__body { display: block; }
.seo-section__help { font-size: 0.85rem; color: var(--muted); margin-bottom: 1.25rem; line-height: 1.2; }
.form-row { margin-bottom: 1.25rem; }
.form-row--2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media (max-width: 640px) { .form-row--2 { grid-template-columns: 1fr; } }
.form-group { margin-bottom: 0; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: rgba(201,42,42,0.5); box-shadow: 0 0 0 2px rgba(201,42,42,0.15); }
.req { color: #f87171; }
.char-count { font-size: 0.8rem; color: var(--muted); margin-top: 0.35rem; display: block; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.current-og-image { margin-bottom: 1rem; }
.current-og-image img { max-height: 140px; border-radius: 10px; border: 1px solid var(--border); }
.remove-check { font-size: 0.85rem; color: var(--muted); margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.checkbox-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 500; }
.form-actions { margin-top: 2rem; }
.btn-save { padding: 0.85rem 1.75rem; font-size: 1rem; font-weight: 700; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 12px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
.btn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(201,42,42,0.4); }
</style>
@endpush

@push('scripts')
<script>
(function() {
    var sections = document.querySelectorAll('.seo-section');
    sections.forEach(function(section) {
        var toggle = section.querySelector('.seo-section__toggle');
        if (toggle) {
            toggle.addEventListener('click', function() {
                section.classList.toggle('is-open');
            });
        }
    });
    sections[0].classList.add('is-open');

    function setCount(countId, inputId) {
        var inputEl = document.getElementById(inputId);
        var countEl = document.getElementById(countId);
        if (inputEl && countEl) {
            countEl.textContent = inputEl.value.length;
            inputEl.addEventListener('input', function() { countEl.textContent = inputEl.value.length; });
        }
    }
    setCount('titleCount', 'meta_title');
    setCount('descCount', 'meta_description');
    setCount('keywordsCount', 'meta_keywords');
    setCount('ogDescCount', 'og_description');
    setCount('schemaDescCount', 'schema_description');
})();
</script>
@endpush
@endsection
