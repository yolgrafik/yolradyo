@extends('admin.layouts.app')

@section('content')
<div class="card-grid">
    <div class="card">
        <div class="card-header accent">Anlik Dinleyici</div>
        <div class="card-body">
            <div class="card-value">0</div>
        </div>
    </div>
    <div class="card">
        <div class="card-header accent">Yayin Durumu</div>
        <div class="card-body">
            <div class="card-value">Offline</div>
        </div>
    </div>
    <div class="card">
        <div class="card-header accent">Now Playing</div>
        <div class="card-body">
            <div class="card-value" style="font-size:1rem;font-weight:400;color:var(--muted)">-</div>
        </div>
    </div>
</div>
@endsection
