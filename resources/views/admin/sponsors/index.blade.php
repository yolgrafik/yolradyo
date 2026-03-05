@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Sponsor Listesi</span>
        <a href="{{ route('admin.sponsors.create') }}" class="quick-btn">+ Sponsor Ekle</a>
    </div>
    <div class="card-body">
        <div class="request-table-wrap" style="overflow-x:auto;">
            <p style="padding:2rem;text-align:center;color:var(--muted);">Henüz sponsor eklenmemiş. "Sponsor Ekle" ile ekleyin.</p>
        </div>
    </div>
</div>
@endsection
