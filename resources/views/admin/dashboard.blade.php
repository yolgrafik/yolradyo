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
@endsection
