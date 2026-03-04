@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>DJ Profilleri</span>
        <a href="{{ route('admin.djs.create') }}" class="quick-btn">+ DJ Ekle</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <p style="margin-bottom:1rem;color:var(--muted);font-size:0.9rem;">Ana sayfada "Yayındaki Kişi" kartında gösterilecek DJ'yi buradan seçin. "CANLI yap" ile o DJ canlı olarak işaretlenir.</p>

        <div class="request-table-wrap" style="overflow-x:auto;">
            <table class="request-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border);">
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Avatar</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Ad</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Slogan</th>
                        <th style="padding:0.75rem;text-align:center;font-size:0.8rem;color:var(--muted);">Canlı</th>
                        <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($djs as $dj)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:0.75rem;">
                            @if($dj->avatar_path)
                                <img src="{{ $dj->avatar_url }}" alt="{{ $dj->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                            @else
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:rgba(201,42,42,0.3);color:#fff;font-weight:700;font-size:0.85rem;">{{ $dj->display_initials }}</span>
                            @endif
                        </td>
                        <td style="padding:0.75rem;font-size:0.9rem;font-weight:600;">{{ $dj->name }}</td>
                        <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);">{{ $dj->bio ?: '—' }}</td>
                        <td style="padding:0.75rem;text-align:center;">
                            @if($dj->is_live)
                                <span class="badge badge-success" style="padding:0.25rem 0.5rem;font-size:0.75rem;">CANLI</span>
                                <form action="{{ route('admin.djs.set-offline', $dj) }}" method="POST" class="d-inline" style="margin-left:0.35rem;">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-muted">CANLI kapat</button>
                                </form>
                            @else
                                <form action="{{ route('admin.djs.set-live', $dj) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-live">CANLI yap</button>
                                </form>
                            @endif
                        </td>
                        <td style="padding:0.75rem;text-align:right;">
                            <a href="{{ route('admin.djs.edit', $dj) }}" class="btn-sm btn-edit">Düzenle</a>
                            <form action="{{ route('admin.djs.destroy', $dj) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu DJ profilini silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:2rem;text-align:center;color:var(--muted);">Henüz DJ profili yok. "DJ Ekle" ile ekleyin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;text-decoration:none;display:inline-block;}
.btn-live{background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;}
.btn-muted{background:rgba(255,255,255,0.1);color:var(--muted);}
.btn-edit{background:rgba(59,130,246,0.25);color:#93c5fd;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
.badge-success{background:rgba(34,197,94,0.3);color:#86efac;}
</style>
@endpush
@endsection
