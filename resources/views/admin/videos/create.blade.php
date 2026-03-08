@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:900px;">
    <div class="card-header">Video Ekle</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data" id="videoForm">
            @csrf
            @include('admin.videos.form-fields', ['video' => null])
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.videos.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>
@include('admin.videos.form-style')
@endsection
