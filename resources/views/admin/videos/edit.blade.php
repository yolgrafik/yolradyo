@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:900px;">
    <div class="card-header">Video Düzenle</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data" id="videoForm">
            @csrf
            @method('PUT')
            @include('admin.videos.form-fields', ['video' => $video])
            <div class="form-actions">
                <button type="submit" class="btn-save">Güncelle</button>
                <a href="{{ route('admin.videos.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>
@include('admin.videos.form-style')
@endsection
