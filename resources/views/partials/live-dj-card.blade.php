{{-- Yayındaki Kişi kartı - $dj null ise gizlenir veya pasif mesaj --}}
<div class="live-card">
    <div class="live-card-title">YAYINDA</div>
    @if($dj ?? null)
    <div class="home-dj-card">
        <div class="dj-avatar">
            @if($dj->avatar_path)
                <img src="{{ $dj->avatar_url }}" alt="{{ $dj->name }}">
            @else
                <span class="dj-initials">{{ $dj->display_initials }}</span>
            @endif
        </div>
        <h3>{{ $dj->name }}</h3>
        @if($dj->bio)
            <p class="dj-slogan">{{ $dj->bio }}</p>
        @endif
        <span class="live-badge">CANLI YAYINDA</span>
    </div>
    @else
    <div class="home-dj-card home-dj-card--empty">
        <p class="dj-slogan" style="margin:0;color:var(--muted);">Şu an canlı yayın yok</p>
    </div>
    @endif
</div>
