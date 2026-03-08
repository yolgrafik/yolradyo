@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Sponsor Listesi</span>
        <a href="{{ route('admin.sponsors.create') }}" class="quick-btn">+ Sponsor Ekle</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="pg-alert">{{ session('success') }}</div>
        @endif
        @if($sponsors->isEmpty())
            <p style="padding:2rem;text-align:center;color:var(--muted);">Henüz sponsor eklenmemiş. "Sponsor Ekle" ile ekleyin.</p>
        @else
            <div class="request-table-wrap" style="overflow-x:auto;">
                <table class="request-table">
                    <thead>
                        <tr>
                            <th>Resim</th>
                            <th>Başlık</th>
                            <th>Kısa Açıklama</th>
                            <th>Sıra</th>
                            <th>Durum</th>
                            <th style="width:180px;">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sponsors as $sponsor)
                            <tr>
                                <td>
                                    @if($sponsor->image_path)
                                        <img src="{{ asset($sponsor->image_path) }}" alt="{{ $sponsor->title }}" style="width:76px;height:48px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,.12);">
                                    @else
                                        <span style="color:var(--muted);font-size:.8rem;">Yok</span>
                                    @endif
                                </td>
                                <td>{{ $sponsor->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($sponsor->short_description, 90) }}</td>
                                <td>{{ $sponsor->sort_order }}</td>
                                <td>{{ $sponsor->is_active ? 'Aktif' : 'Pasif' }}</td>
                                <td>
                                    <div class="admin-action-wrap">
                                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn-sm btn-edit">Düzenle</a>
                                        <form method="POST" action="{{ route('admin.sponsors.destroy', $sponsor) }}" class="d-inline" onsubmit="return confirm('Sponsor silinsin mi?');">
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
            <div style="margin-top:.8rem;">{{ $sponsors->links() }}</div>
        @endif
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
