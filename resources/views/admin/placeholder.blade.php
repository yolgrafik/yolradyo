@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ $title ?? 'Sayfa' }}</div>
    <div class="card-body">
        <p style="color:var(--muted);">Bu sayfa henüz hazırlanıyor.</p>
    </div>
</div>
@endsection
