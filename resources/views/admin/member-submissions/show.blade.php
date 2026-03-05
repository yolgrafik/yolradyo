@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Gönderi Detayı</span>
        <a href="{{ route('admin.member-submissions.index') }}" class="btn-sm btn-edit">← Listeye Dön</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <dl style="display:grid;gap:0.75rem;">
            <div><dt style="color:var(--muted);font-size:0.85rem;">Üye</dt><dd>{{ $submission->user->name }} ({{ $submission->user->email }})</dd></div>
            <div><dt style="color:var(--muted);font-size:0.85rem;">Tür</dt><dd>{{ $submission->type_label }}</dd></div>
            <div><dt style="color:var(--muted);font-size:0.85rem;">Başlık</dt><dd>{{ $submission->title }}</dd></div>
            @if($submission->description)
                <div><dt style="color:var(--muted);font-size:0.85rem;">Açıklama</dt><dd style="white-space:pre-wrap;">{{ $submission->description }}</dd></div>
            @endif
            @if($submission->video_url)
                <div><dt style="color:var(--muted);font-size:0.85rem;">Video Link</dt><dd><a href="{{ $submission->video_url }}" target="_blank" rel="noopener">{{ $submission->video_url }}</a></dd></div>
            @endif
            @if($submission->file_path)
                <div><dt style="color:var(--muted);font-size:0.85rem;">MP3 Dosyası</dt><dd><a href="{{ route('admin.member-submissions.download', $submission) }}">{{ $submission->file_name ?? 'İndir' }}</a></dd></div>
            @endif
            <div><dt style="color:var(--muted);font-size:0.85rem;">Tarih</dt><dd>{{ $submission->created_at->format('d.m.Y H:i') }}</dd></div>
            <div><dt style="color:var(--muted);font-size:0.85rem;">Durum</dt><dd>{{ $submission->status_label }}</dd></div>
        </dl>

        <div style="margin-top:1.5rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
            @if($submission->status === 'pending')
                <form action="{{ route('admin.member-submissions.approve', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-save">Onayla</button>
                </form>
                <form action="{{ route('admin.member-submissions.reject', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-sm btn-danger">Reddet</button>
                </form>
            @endif
            @if($submission->type === 'mp3' && $submission->file_path)
                <a href="{{ route('admin.member-submissions.download', $submission) }}" class="btn-sm btn-edit">MP3 İndir</a>
            @endif
            @if($submission->video_url)
                <a href="{{ $submission->video_url }}" target="_blank" rel="noopener" class="btn-sm btn-edit">Video Aç</a>
            @endif
            <form action="{{ route('admin.member-submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Sil</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;margin-bottom:1rem;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;text-decoration:none;display:inline-block;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
</style>
@endpush
@endsection
