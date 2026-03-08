@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Tum Haberler</span>
        <a href="{{ route('admin.news.create') }}" class="quick-btn">+ Haber Ekle</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($news->isEmpty())
            <p class="muted" style="text-align:center;padding:2rem;">Henuz haber eklenmemis. <a href="{{ route('admin.news.create') }}" style="color:var(--accent);">Ilk haberi ekleyin</a>.</p>
        @else
            <div class="news-table-wrap">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th>Gorsel</th>
                            <th>Baslik</th>
                            <th>Kisa Aciklama</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th>Islem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>
                                <div class="news-thumb">
                                    @if($item->cover_image)
                                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}">
                                    @else
                                        <span>Yok</span>
                                    @endif
                                </div>
                            </td>
                            <td class="news-title">{{ $item->title }}</td>
                            <td class="news-excerpt">{{ \Illuminate\Support\Str::limit($item->excerpt ?: '-', 90) }}</td>
                            <td>{{ $item->created_at?->format('d.m.Y H:i') }}</td>
                            <td><span class="badge {{ $item->status ? 'badge-success' : 'badge-muted' }}">{{ $item->status ? 'Aktif' : 'Pasif' }}</span></td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.news.edit', $item) }}" class="btn-sm btn-edit">Duzenle</a>
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Haberi silmek istediginize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-danger">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.news-table-wrap{overflow:auto;border:1px solid var(--border);border-radius:12px;}
.news-table{width:100%;border-collapse:collapse;min-width:860px;}
.news-table th,.news-table td{padding:0.75rem 0.8rem;border-bottom:1px solid var(--border);text-align:left;font-size:0.85rem;vertical-align:middle;}
.news-table thead th{background:rgba(255,255,255,0.04);font-weight:700;color:var(--text);}
.news-thumb{width:90px;height:56px;border-radius:8px;overflow:hidden;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:0.75rem;}
.news-thumb img{width:100%;height:100%;object-fit:cover;}
.news-title{font-weight:700;color:var(--text);max-width:220px;}
.news-excerpt{color:var(--muted);max-width:260px;}
.badge{padding:0.2rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;display:inline-block;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.actions{display:flex;gap:0.45rem;align-items:center;}
.muted{color:var(--muted);}
</style>
@endpush
@endsection
