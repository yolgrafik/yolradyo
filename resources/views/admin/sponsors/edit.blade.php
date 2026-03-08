@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Sponsor Düzenle</div>
    <div class="card-body">
        @if($errors->any())
            <div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.sponsors.update', $sponsor) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.sponsors.form', ['sponsor' => $sponsor])
            <div class="pg-actions">
                <button class="btn-save" type="submit">Güncelle</button>
                <a class="btn-cancel" href="{{ route('admin.sponsors.index') }}">Geri</a>
            </div>
        </form>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
