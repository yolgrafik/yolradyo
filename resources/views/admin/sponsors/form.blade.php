<div class="pg-form-group">
    <label>Başlık</label>
    <input type="text" name="title" class="pg-input" value="{{ old('title', $sponsor->title ?? '') }}" required>
</div>

<div class="pg-form-group">
    <label>Kısa Açıklama</label>
    <textarea name="short_description" rows="4" class="pg-input" placeholder="Kartlarda ve özetlerde görünecek kısa metin">{{ old('short_description', $sponsor->short_description ?? '') }}</textarea>
</div>

<div class="pg-form-group">
    <label>Detaylı Açıklama</label>
    <textarea name="description" rows="6" class="pg-input" placeholder="Sponsor detay sayfasında görünecek uzun açıklama">{{ old('description', $sponsor->description ?? '') }}</textarea>
</div>

<div class="pg-form-group">
    <label>Resimler (çoklu yükleme)</label>
    <input type="file" name="images[]" class="pg-input" accept="image/*" multiple>
    <p class="pg-hint" style="margin-top:.4rem;font-size:.82rem;color:var(--muted);">Birden fazla resim seçebilirsiniz. İlk resim ana sayfa ve detayda büyük görünür.</p>
    @php
        $galleryImgs = $sponsor?->getGalleryImages() ?? [];
    @endphp
    @if(!empty($galleryImgs))
        <div class="sponsor-images-preview" style="margin-top:.8rem;display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($galleryImgs as $idx => $path)
                <div class="sponsor-image-item" style="position:relative;">
                    <input type="hidden" name="existing_images[]" value="{{ $path }}">
                    <img src="{{ asset($path) }}" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,.15);">
                    <button type="button" class="sponsor-image-remove" data-path="{{ $path }}" style="position:absolute;top:-6px;right:-6px;width:22px;height:22px;border-radius:50%;border:none;background:#dc2626;color:#fff;cursor:pointer;font-size:12px;line-height:1;display:flex;align-items:center;justify-content:center;" title="Kaldır">×</button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="pg-form-group">
    <label>Video Türü</label>
    <select name="video_type" id="sponsorVideoType" class="pg-input">
        <option value="none" {{ old('video_type', $sponsor->video_type ?? 'none') === 'none' ? 'selected' : '' }}>Yok</option>
        <option value="youtube" {{ old('video_type', $sponsor->video_type ?? '') === 'youtube' ? 'selected' : '' }}>YouTube Link</option>
        <option value="mp4" {{ old('video_type', $sponsor->video_type ?? '') === 'mp4' ? 'selected' : '' }}>MP4 Yükle</option>
    </select>
</div>
<div class="pg-form-group sponsor-video-field" id="sponsorVideoYoutubeWrap" style="display:none;">
    <label>YouTube Video Linki</label>
    <input type="url" name="video_youtube_url" id="sponsorVideoYoutubeUrl" class="pg-input" value="{{ old('video_youtube_url', $sponsor->video_youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=... veya https://youtu.be/...">
</div>
<div class="pg-form-group sponsor-video-field" id="sponsorVideoMp4Wrap" style="display:none;">
    <label>MP4 Video Yükle</label>
    <input type="file" name="video_file" id="sponsorVideoFile" class="pg-input" accept="video/mp4,.mp4">
    @if(!empty($sponsor?->video_path))
        <div style="margin-top:.6rem;font-size:.85rem;color:var(--muted);">Mevcut video: {{ basename($sponsor->video_path) }}</div>
    @endif
</div>

<div class="pg-grid">
    <div class="pg-form-group">
        <label>Website Linki</label>
        <input type="url" name="website_url" class="pg-input" value="{{ old('website_url', $sponsor->website_url ?? '') }}" placeholder="https://ornek.com">
    </div>
    <div class="pg-form-group">
        <label>Facebook Linki</label>
        <input type="url" name="facebook_url" class="pg-input" value="{{ old('facebook_url', $sponsor->facebook_url ?? '') }}" placeholder="https://facebook.com/...">
    </div>
    <div class="pg-form-group">
        <label>Instagram Linki</label>
        <input type="url" name="instagram_url" class="pg-input" value="{{ old('instagram_url', $sponsor->instagram_url ?? '') }}" placeholder="https://instagram.com/...">
    </div>
    <div class="pg-form-group">
        <label>X (Twitter) Linki</label>
        <input type="url" name="x_url" class="pg-input" value="{{ old('x_url', $sponsor->x_url ?? '') }}" placeholder="https://x.com/...">
    </div>
    <div class="pg-form-group">
        <label>YouTube Linki</label>
        <input type="url" name="youtube_url" class="pg-input" value="{{ old('youtube_url', $sponsor->youtube_url ?? '') }}" placeholder="https://youtube.com/...">
    </div>
    <div class="pg-form-group">
        <label>Sıra</label>
        <input type="number" name="sort_order" class="pg-input" min="0" value="{{ old('sort_order', $sponsor->sort_order ?? 0) }}">
    </div>
</div>

<label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;">
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sponsor->is_active ?? true) ? 'checked' : '' }}>
    Durum (Aktif/Pasif)
</label>

@push('scripts')
<script>
(function(){
    document.querySelectorAll('.sponsor-image-remove').forEach(function(btn){
        btn.addEventListener('click', function(){
            var item = btn.closest('.sponsor-image-item');
            if (item) item.remove();
        });
    });
    var sel = document.getElementById('sponsorVideoType');
    var ytWrap = document.getElementById('sponsorVideoYoutubeWrap');
    var mp4Wrap = document.getElementById('sponsorVideoMp4Wrap');
    var ytInput = document.getElementById('sponsorVideoYoutubeUrl');
    var fileInput = document.getElementById('sponsorVideoFile');
    function toggle() {
        var v = sel ? sel.value : 'none';
        if (ytWrap) ytWrap.style.display = v === 'youtube' ? 'block' : 'none';
        if (mp4Wrap) mp4Wrap.style.display = v === 'mp4' ? 'block' : 'none';
    }
    if (sel) sel.addEventListener('change', toggle);
    toggle();
})();
</script>
@endpush
