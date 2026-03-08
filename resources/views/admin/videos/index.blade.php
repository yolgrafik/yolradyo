@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
        <div>
            <h1 style="font-size:1.2rem;font-weight:700;margin:0;">Videolar</h1>
            <p style="font-size:0.88rem;color:var(--muted);margin-top:0.35rem;">Video Galeri içeriklerini buradan yönetin.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="btn-save" style="text-decoration:none;">Video Ekle</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($videos->isEmpty())
            <div style="padding:1rem;color:var(--muted);">Henüz video eklenmedi.</div>
        @else
            <div style="overflow:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left;padding:10px;border-bottom:1px solid var(--border);">Sıra</th>
                            <th style="text-align:left;padding:10px;border-bottom:1px solid var(--border);">Başlık</th>
                            <th style="text-align:left;padding:10px;border-bottom:1px solid var(--border);">Tür</th>
                            <th style="text-align:left;padding:10px;border-bottom:1px solid var(--border);">Durum</th>
                            <th style="text-align:right;padding:10px;border-bottom:1px solid var(--border);">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($videos as $video)
                            <tr>
                                <td style="padding:10px;border-bottom:1px solid var(--border);">{{ $video->sort_order }}</td>
                                <td style="padding:10px;border-bottom:1px solid var(--border);">{{ $video->title }}</td>
                                <td style="padding:10px;border-bottom:1px solid var(--border);">{{ strtoupper($video->video_type) }}</td>
                                <td style="padding:10px;border-bottom:1px solid var(--border);">
                                    @if($video->is_active)
                                        <span style="color:#86efac;">Aktif</span>
                                    @else
                                        <span style="color:#fca5a5;">Pasif</span>
                                    @endif
                                </td>
                                <td style="padding:10px;border-bottom:1px solid var(--border);text-align:right;">
                                    <a href="{{ route('admin.videos.edit', $video) }}" class="btn-cancel" style="margin-right:8px;text-decoration:none;">Düzenle</a>
                                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" style="display:inline;" onsubmit="return confirm('Silinsin mi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-save" style="background:#7f1d1d;">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
