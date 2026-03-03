@extends('admin.layouts.app')

@section('content')
<div class="card-grid">
    <div class="card">
        <div class="card-header">Anlik Dinleyici</div>
        <div class="card-body">
            <div class="card-value">0</div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Yayin Durumu</div>
        <div class="card-body">
            <div class="card-value">Offline</div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Now Playing</div>
        <div class="card-body">
            <div class="card-value card-value-muted">-</div>
        </div>
    </div>
</div>

<div class="dash-row">
    <div class="dash-box">
        <h3 class="dash-box__title">Hizli Islemler</h3>
        <div class="quick-actions">
            <a href="#" class="quick-btn">Haber Ekle</a>
            <a href="#" class="quick-btn">Video Ekle</a>
            <a href="#" class="quick-btn">Album Olustur</a>
            <a href="#" class="quick-btn">Mesajlar</a>
        </div>
    </div>
    <div class="dash-box">
        <h3 class="dash-box__title">Son Aktivite</h3>
        <ul class="activity-list">
            <li class="activity-item"><strong>Son giris:</strong> Bugun 18:30</li>
            <li class="activity-item"><strong>Son haber:</strong> "Yeni yayin programi duyuruldu"</li>
            <li class="activity-item"><strong>Son mesaj:</strong> "Dinleyici istek: Sezen Aksu - Firuze"</li>
        </ul>
    </div>
</div>
@endsection
