@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Yayın Takvimi</span>
        <button type="button" class="quick-btn" id="btnAdd">+ Ekle</button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="day-tabs-wrapper">
            <div class="day-tabs">
                @foreach($dayLabels as $d => $label)
                    <a href="{{ route('admin.schedule.index', ['day' => $d]) }}" class="day-tab {{ $currentDay == $d ? 'active' : '' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>

        <div class="schedule-actions-row" style="margin-top:1rem;display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;">
            <span class="muted" style="font-size:0.9rem;">{{ $dayLabels[$currentDay] }} programları</span>
            @if($schedules->isNotEmpty())
                <div class="copy-form" style="margin-left:auto;">
                    <form action="{{ route('admin.schedule.copy', $currentDay) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu günü seçilen güne kopyalamak istiyor musunuz?');">
                        @csrf
                        <select name="to_day" class="copy-select" style="padding:0.4rem 0.6rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:0.85rem;">
                            @foreach($dayLabels as $d => $label)
                                @if($d != $currentDay)
                                    <option value="{{ $d }}">→ {{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn-sm btn-copy">Bu günü kopyala</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="schedule-table-wrap" style="margin-top:1rem;overflow-x:auto;">
            <table class="schedule-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border);">
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Saat</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Program</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Sunucu</th>
                        <th style="padding:0.75rem;text-align:center;font-size:0.8rem;color:var(--muted);">Durum</th>
                        <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $s)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:0.75rem;font-size:0.9rem;font-weight:600;color:var(--accent);">{{ $s->start_time_formatted }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $s->title }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;color:var(--muted);">{{ $s->host ?: '—' }}</td>
                        <td style="padding:0.75rem;text-align:center;">
                            <form action="{{ route('admin.schedule.toggle', $s) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="badge {{ $s->is_active ? 'badge-success' : 'badge-muted' }}" style="border:none;cursor:pointer;padding:0.25rem 0.5rem;font-size:0.75rem;">
                                    {{ $s->is_active ? 'Aktif' : 'Pasif' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding:0.75rem;text-align:right;">
                            <button type="button" class="btn-sm btn-edit" data-edit="{{ $s->id }}" data-title="{{ $s->title }}" data-host="{{ $s->host ?? '' }}" data-start="{{ $s->start_time_formatted }}" data-end="{{ $s->end_time ? substr($s->end_time, 0, 5) : '' }}" data-active="{{ $s->is_active ? '1' : '0' }}">Düzenle</button>
                            <form action="{{ route('admin.schedule.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:2rem;text-align:center;color:var(--muted);">Bu gün için program yok. "Ekle" ile ekleyin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="scheduleModal" class="modal-overlay" style="display:none;">
    <div class="modal-backdrop" data-close-modal></div>
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modalTitle">Program Ekle</h3>
            <button type="button" class="modal-close" data-close-modal>&times;</button>
        </div>
        <form id="scheduleForm" method="POST" action="{{ route('admin.schedule.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="day_of_week" value="{{ $currentDay }}">
            <div class="form-group">
                <label for="start_time">Başlangıç *</label>
                <input type="time" name="start_time" id="start_time" required class="form-input">
            </div>
            <div class="form-group">
                <label for="end_time">Bitiş</label>
                <input type="time" name="end_time" id="end_time" class="form-input">
            </div>
            <div class="form-group">
                <label for="title">Program Adı *</label>
                <input type="text" name="title" id="title" required maxlength="255" class="form-input" placeholder="Örn: Sabah Kuşağı">
            </div>
            <div class="form-group">
                <label for="host">Sunucu / DJ</label>
                <input type="text" name="host" id="host" maxlength="255" class="form-input" placeholder="Örn: Desmal">
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" checked> Aktif
                </label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-close-modal>İptal</button>
                <button type="submit" class="quick-btn">Kaydet</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.day-tabs-wrapper{background:linear-gradient(180deg,#111722,#0b0f18);padding:14px 16px;border-radius:12px;border:1px solid rgba(255,255,255,0.08);margin-bottom:20px;}
.day-tabs{display:flex;gap:10px;flex-wrap:nowrap;overflow-x:auto;scrollbar-width:none;}
.day-tabs::-webkit-scrollbar{display:none;}
.day-tab{padding:10px 18px;border-radius:10px;background:#1b2230;color:#ffffff;border:1px solid rgba(255,255,255,0.15);font-weight:600;text-decoration:none;font-size:0.9rem;flex:0 0 auto;transition:all 0.2s ease;}
.day-tab:hover{background:#273043;}
.day-tab.active{background:linear-gradient(135deg,#ff3b3b,#b30000);color:white;border:none;}
.badge{padding:0.25rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;margin-left:0.25rem;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.btn-copy{background:rgba(234,179,8,0.2);color:#fde047;}
.d-inline{display:inline;}
.muted{color:var(--muted);}
.modal-overlay{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;}
.modal-backdrop{position:absolute;inset:0;background:rgba(0,0,0,0.6);}
.modal-box{position:relative;background:var(--card);border:1px solid var(--border);border-radius:14px;padding:1.5rem;min-width:320px;max-width:420px;width:100%;}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.modal-header h3{margin:0;font-size:1.1rem;}
.modal-close{background:none;border:none;color:var(--muted);font-size:1.5rem;cursor:pointer;padding:0;}
.form-group{margin-bottom:1rem;}
.form-group label{display:block;margin-bottom:0.35rem;font-size:0.85rem;color:var(--muted);}
.form-input{width:100%;padding:0.6rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:0.9rem;}
.checkbox-label{display:flex;align-items:center;gap:0.5rem;cursor:pointer;}
.modal-actions{display:flex;gap:0.5rem;justify-content:flex-end;margin-top:1.25rem;}
.btn-secondary{padding:0.5rem 1rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);cursor:pointer;}
</style>
@endpush
@push('scripts')
<script>
(function(){
    var modal=document.getElementById('scheduleModal');
    var form=document.getElementById('scheduleForm');
    var btnAdd=document.getElementById('btnAdd');
    var editBtns=document.querySelectorAll('[data-edit]');

    function openModal(){if(modal){modal.style.display='flex';}}
    function closeModal(){if(modal){modal.style.display='none';}}
    document.querySelectorAll('[data-close-modal]').forEach(function(el){el.addEventListener('click',closeModal);});

    btnAdd&&btnAdd.addEventListener('click',function(){
        form.action='{{ route("admin.schedule.store") }}';
        form.querySelector('#formMethod').value='POST';
        document.getElementById('modalTitle').textContent='Program Ekle';
        form.reset();
        form.querySelector('input[name="day_of_week"]').value='{{ $currentDay }}';
        form.querySelector('input[name="is_active"]').checked=true;
        openModal();
    });

    editBtns.forEach(function(btn){
        btn.addEventListener('click',function(){
            var id=btn.dataset.edit;
            var title=btn.dataset.title;
            var host=btn.dataset.host||'';
            var start=btn.dataset.start||'';
            var end=btn.dataset.end||'';
            var active=btn.dataset.active==='1';
            form.action='{{ url("admin/schedule") }}/'+id;
            form.querySelector('#formMethod').value='PUT';
            document.getElementById('modalTitle').textContent='Program Düzenle';
            document.getElementById('title').value=title;
            document.getElementById('host').value=host;
            document.getElementById('start_time').value=start;
            document.getElementById('end_time').value=end;
            form.querySelector('input[name="is_active"]').checked=active;
            openModal();
        });
    });
})();
</script>
@endpush
@endsection
