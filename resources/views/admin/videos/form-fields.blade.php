@php
    $isEdit = isset($video) && $video;
    $type = old('video_type', $video->video_type ?? 'youtube');
@endphp

<div class="form-group">
    <label for="title">Başlık *</label>
    <input type="text" name="title" id="title" required value="{{ old('title', $video->title ?? '') }}" class="form-input">
</div>

<div class="form-group">
    <label for="short_description">Kısa Açıklama</label>
    <textarea name="short_description" id="short_description" rows="3" class="form-input">{{ old('short_description', $video->short_description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="cover_image">Kapak Resmi / Önizleme Görseli</label>
    <p class="form-hint" id="coverHint">MP4 için önizlemede kullanılır. YouTube için otomatik thumbnail gelir; isterseniz özel kapak da yükleyebilirsiniz.</p>
    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/jpg,image/png,image/webp,image/gif" class="form-input">
    @if($isEdit && !empty($video->cover_image_path))
        <div class="preview-wrap" style="margin-top:.5rem;"><img src="{{ asset($video->cover_image_path) }}" class="preview-img" alt="" style="max-width:160px;max-height:90px;object-fit:cover;border-radius:6px;"></div>
    @endif
</div>

<div class="form-group">
    <label for="video_type">Video Türü *</label>
    <select name="video_type" id="video_type" class="form-input">
        <option value="mp4" {{ $type === 'mp4' ? 'selected' : '' }}>MP4</option>
        <option value="youtube" {{ $type === 'youtube' ? 'selected' : '' }}>YouTube</option>
    </select>
</div>

<div class="form-group" id="mp4Field">
    <label for="mp4_file">MP4 Video Yükleme</label>
    <input type="file" name="mp4_file" id="mp4_file" accept="video/mp4" class="form-input">
    @if($isEdit && !empty($video->mp4_path))
        <span class="form-hint">Yüklü dosya: {{ basename($video->mp4_path) }}</span>
    @endif
</div>

<div class="form-group" id="youtubeField">
    <label for="youtube_url">YouTube Linki</label>
    <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $video->youtube_url ?? '') }}" class="form-input" placeholder="https://www.youtube.com/watch?v=...">
</div>

<div class="form-group">
    <label for="sort_order">Sıra</label>
    <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $video->sort_order ?? 0) }}" class="form-input">
</div>

<div class="form-group">
    <label class="checkbox-label">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $video->is_active ?? true) ? 'checked' : '' }}>
        Durum (Aktif/Pasif)
    </label>
</div>

<div class="form-group">
    <label class="checkbox-label">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $video->is_featured ?? false) ? 'checked' : '' }}>
        Öne Çıkan mı
    </label>
</div>

@push('scripts')
<script>
(function(){
    var typeEl = document.getElementById('video_type');
    var mp4Field = document.getElementById('mp4Field');
    var ytField = document.getElementById('youtubeField');
    if (!typeEl || !mp4Field || !ytField) return;

    function toggleFields() {
        var isMp4 = typeEl.value === 'mp4';
        mp4Field.style.display = isMp4 ? 'block' : 'none';
        ytField.style.display = isMp4 ? 'none' : 'block';
    }
    typeEl.addEventListener('change', toggleFields);
    toggleFields();
})();
</script>
@endpush
