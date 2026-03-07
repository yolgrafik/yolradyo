@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <span>Sponsor Ekle</span>
    </div>
    <div class="card-body">
        <p style="color:var(--muted);">Sponsor ekleme formu buraya eklenecek.</p>
        <a href="{{ route('admin.sponsors.index') }}" class="quick-btn" style="margin-top:1rem;">← Sponsor Listesine Dön</a>
    </div>
</div>
@endsection
