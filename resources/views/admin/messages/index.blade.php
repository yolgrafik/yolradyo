@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Gelen Mesajlar</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="filter-form" style="margin-bottom:1.25rem;display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ara (isim, sanatçı, türkü, mesaj...)" class="filter-input" style="flex:1;min-width:200px;padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);">
            <select name="days" class="filter-select" style="padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);">
                <option value="">Tümü</option>
                <option value="7" {{ request('days') === '7' ? 'selected' : '' }}>Son 7 gün</option>
                <option value="30" {{ request('days') === '30' ? 'selected' : '' }}>Son 30 gün</option>
            </select>
            <button type="submit" class="quick-btn">Filtrele</button>
        </form>

        <form method="POST" action="{{ route('admin.messages.bulk-destroy') }}" id="bulkForm" onsubmit="return confirm('Seçilen kayıtları silmek istediğinize emin misiniz?');">
            @csrf
            <div style="margin-bottom:0.75rem;">
                <button type="button" class="quick-btn" id="selectAll">Tümünü Seç</button>
                <button type="submit" class="quick-btn" style="background:rgba(239,68,68,0.3);color:#fca5a5;">Seçilenleri Sil</button>
            </div>
            <div class="request-table-wrap" style="overflow-x:auto;">
                <table class="request-table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border);">
                            <th style="padding:0.75rem;width:40px;"><input type="checkbox" id="checkAll"></th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Tarih</th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">İsim Soyad</th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Sanatçı</th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Türkü</th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Mesaj</th>
                            <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Onay Tarihi</th>
                            <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $m)
                        <tr style="border-bottom:1px solid var(--border);">
                            <td style="padding:0.75rem;"><input type="checkbox" name="ids[]" value="{{ $m->id }}" class="row-check"></td>
                            <td style="padding:0.75rem;font-size:0.85rem;">{{ $m->created_at->format('d.m.Y H:i') }}</td>
                            <td style="padding:0.75rem;font-size:0.9rem;">{{ $m->full_name }}</td>
                            <td style="padding:0.75rem;font-size:0.9rem;">{{ $m->artist_name }}</td>
                            <td style="padding:0.75rem;font-size:0.9rem;">{{ $m->song_name }}</td>
                            <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);max-width:200px;">{{ Str::limit($m->message, 50) ?: '—' }}</td>
                            <td style="padding:0.75rem;font-size:0.85rem;">{{ $m->approved_at ? $m->approved_at->format('d.m.Y H:i') : '—' }}</td>
                            <td style="padding:0.75rem;text-align:right;">
                                <form action="{{ route('admin.song-requests.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding:2rem;text-align:center;color:var(--muted);">Onaylanmış mesaj bulunmuyor.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if($messages->hasPages())
            <div style="margin-top:1rem;">{{ $messages->links() }}</div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;margin-left:0.25rem;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
nav[aria-label="Pagination"] ul{display:flex;gap:0.5rem;list-style:none;margin:0;padding:0;flex-wrap:wrap;}
nav[aria-label="Pagination"] a,nav[aria-label="Pagination"] span{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);text-decoration:none;font-size:0.9rem;}
nav[aria-label="Pagination"] a:hover{background:rgba(201,42,42,0.2);border-color:var(--accent);}
nav[aria-label="Pagination"] span{color:var(--muted);}
</style>
@endpush
@push('scripts')
<script>
(function(){
    var checkAll=document.getElementById('checkAll');
    var rowChecks=document.querySelectorAll('.row-check');
    var selectAllBtn=document.getElementById('selectAll');
    if(checkAll){
        checkAll.addEventListener('change',function(){ rowChecks.forEach(function(c){ c.checked=checkAll.checked; }); });
    }
    if(selectAllBtn){
        selectAllBtn.addEventListener('click',function(){
            var allChecked=Array.from(rowChecks).every(function(c){ return c.checked; });
            rowChecks.forEach(function(c){ c.checked=!allChecked; });
            if(checkAll) checkAll.checked=!allChecked;
        });
    }
})();
</script>
@endpush
@endsection
