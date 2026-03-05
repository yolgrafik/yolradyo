@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Yayın Takvimi</span>
        <div style="display:flex;gap:0.5rem;align-items:center;">
            <span class="schedule-day-label">{{ $dayLabels[$currentDay] }}</span>
            <button type="button" class="quick-btn" id="btnAdd">+ Program Ekle</button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="schedule-layout">
            <div class="schedule-sidebar">
                <div class="day-tabs-wrapper">
                    <div class="day-tabs-label">Gün Seçimi</div>
                    <div class="day-tabs">
                        @foreach($dayLabels as $d => $label)
                            <a href="{{ route('admin.schedule.index', ['day' => $d]) }}" class="day-tab {{ $currentDay == $d ? 'active' : '' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="quick-add-section">
                    <div class="quick-add-header">
                        <span class="quick-add-label">Hızlı Ekle</span>
                        <button type="button" class="preset-add-btn" id="btnAddPreset" title="Yeni preset ekle">+</button>
                    </div>
                    <div class="quick-add-btns">
                        @foreach($presets as $p)
                        <div class="preset-item">
                            <button type="button" class="quick-add-btn" data-preset="{{ $p->title }}" data-start="{{ $p->start_formatted }}" data-end="{{ $p->end_formatted }}">{{ $p->title }}</button>
                            <div class="preset-actions">
                                <button type="button" class="preset-edit" data-id="{{ $p->id }}" data-title="{{ $p->title }}" data-start="{{ $p->start_formatted }}" data-end="{{ $p->end_formatted }}" title="Düzenle">✎</button>
                                <form action="{{ route('admin.schedule.presets.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu preset silinsin mi?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="day" value="{{ $currentDay }}">
                                    <button type="submit" class="preset-delete" title="Sil">×</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        @if($presets->isEmpty())
                        <p class="preset-empty">Preset yok. + ile ekleyin.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="schedule-main">
                <div class="schedule-day-header">
                    <span>{{ $dayLabels[$currentDay] }} programları</span>
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
                        <td style="padding:0.75rem;font-size:0.9rem;color:var(--muted);">{{ $s->host_name }}</td>
                        <td style="padding:0.75rem;text-align:center;">
                            <form action="{{ route('admin.schedule.toggle', $s) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="badge {{ $s->is_active ? 'badge-success' : 'badge-muted' }}" style="border:none;cursor:pointer;padding:0.25rem 0.5rem;font-size:0.75rem;">
                                    {{ $s->is_active ? 'Aktif' : 'Pasif' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding:0.75rem;text-align:right;">
                            <button type="button" class="btn-sm btn-edit" data-edit="{{ $s->id }}" data-title="{{ $s->title }}" data-description="{{ $s->description ?? '' }}" data-dj-id="{{ $s->dj_id ?? '' }}" data-programci-id="{{ $s->programci_id ?? '' }}" data-start="{{ $s->start_time_formatted }}" data-end="{{ $s->end_time_formatted }}" data-active="{{ $s->is_active ? '1' : '0' }}">Düzenle</button>
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
    </div>
</div>

<div id="presetModal" class="modal-overlay" style="display:none;">
    <div class="modal-backdrop" data-close-preset-modal></div>
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="presetModalTitle">Preset Ekle</h3>
            <button type="button" class="modal-close" data-close-preset-modal>&times;</button>
        </div>
        <form id="presetForm" method="POST" action="{{ route('admin.schedule.presets.store') }}">
            @csrf
            <input type="hidden" name="_method" id="presetFormMethod" value="POST">
            <input type="hidden" name="day" value="{{ $currentDay }}">
            <div class="form-group">
                <label for="preset_title">Program Adı *</label>
                <input type="text" name="title" id="preset_title" required maxlength="255" class="form-input" placeholder="Örn: Gece Kuşağı">
            </div>
            <div class="form-group">
                <label for="preset_start">Başlangıç *</label>
                <input type="time" name="start_time" id="preset_start" required class="form-input">
            </div>
            <div class="form-group">
                <label for="preset_end">Bitiş</label>
                <input type="time" name="end_time" id="preset_end" class="form-input">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-close-preset-modal>İptal</button>
                <button type="submit" class="quick-btn">Kaydet</button>
            </div>
        </form>
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
                <label for="preset_select">Program Adı *</label>
                <select id="preset_select" class="form-input">
                    <option value="">— Hızlı Ekle'den seçin —</option>
                    @foreach($presets as $p)
                        <option value="{{ $p->title }}" data-start="{{ $p->start_formatted }}" data-end="{{ $p->end_formatted }}">{{ $p->title }}</option>
                    @endforeach
                    <option value="__custom__">— Özel girin —</option>
                </select>
                <input type="text" name="title" id="title" required maxlength="255" class="form-input mt-1" placeholder="Özel program adı" style="display:none;">
            </div>
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea name="description" id="description" rows="3" maxlength="1000" class="form-input" placeholder="Program hakkında kısa açıklama"></textarea>
            </div>
            <div class="form-group">
                <label for="start_time">Başlangıç *</label>
                <input type="time" name="start_time" id="start_time" required class="form-input">
            </div>
            <div class="form-group">
                <label for="end_time">Bitiş</label>
                <input type="time" name="end_time" id="end_time" class="form-input">
            </div>
            <div class="form-group">
                <label for="programci_id">Programcı Seç</label>
                <select name="programci_id" id="programci_id" class="form-input">
                    <option value="">— Programcı seçin —</option>
                    @foreach($programcilar ?? [] as $p)
                        <option value="{{ $p->id }}">{{ $p->ad }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dj_id">DJ Seç (yedek)</label>
                <select name="dj_id" id="dj_id" class="form-input">
                    <option value="">— DJ seçin —</option>
                    @foreach($djProfiles as $dj)
                        <option value="{{ $dj->id }}">{{ $dj->name }}</option>
                    @endforeach
                </select>
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
.schedule-layout{display:flex;gap:1.5rem;margin-bottom:1.5rem;}
.schedule-sidebar{flex:0 0 220px;}
.schedule-main{flex:1;min-width:0;}
.schedule-day-label{font-size:0.9rem;color:var(--muted);}
.day-tabs-wrapper{background:linear-gradient(180deg,#111722,#0b0f18);padding:14px 16px;border-radius:12px;border:1px solid rgba(255,255,255,0.08);margin-bottom:12px;}
.day-tabs-label{font-size:0.75rem;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;}
.day-tabs{display:flex;flex-direction:column;gap:6px;}
.day-tab{padding:8px 12px;font-size:13px;font-weight:600;border-radius:8px;background:#1b2230;color:#ffffff;border:1px solid rgba(255,255,255,0.15);text-decoration:none;transition:all 0.2s ease;}
.day-tab:hover{background:#273043;}
.day-tab.active{background:linear-gradient(135deg,#ff3b3b,#b30000);color:white;border:none;}
.quick-add-section{background:linear-gradient(180deg,#111722,#0b0f18);padding:14px 16px;border-radius:12px;border:1px solid rgba(255,255,255,0.08);}
.quick-add-label{font-size:0.75rem;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;}
.quick-add-btns{display:flex;flex-direction:column;gap:6px;}
.quick-add-btn{padding:8px 12px;font-size:12px;font-weight:600;border-radius:8px;background:rgba(255,255,255,0.06);color:var(--text);border:1px solid var(--border);cursor:pointer;text-align:left;transition:all 0.2s;}
.quick-add-btn:hover{background:rgba(220,38,38,0.2);border-color:var(--accent);}
.quick-add-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.preset-add-btn{width:24px;height:24px;border-radius:6px;background:rgba(34,197,94,0.3);color:#86efac;border:1px solid rgba(34,197,94,0.5);cursor:pointer;font-size:16px;line-height:1;display:flex;align-items:center;justify-content:center;padding:0;}
.preset-add-btn:hover{background:rgba(34,197,94,0.5);}
.preset-item{display:flex;align-items:center;gap:4px;margin-bottom:4px;}
.preset-item:last-child{margin-bottom:0;}
.preset-item .quick-add-btn{flex:1;}
.preset-actions{display:flex;gap:2px;}
.preset-edit,.preset-delete{width:24px;height:24px;border:none;border-radius:4px;background:rgba(255,255,255,0.06);color:var(--muted);cursor:pointer;font-size:12px;line-height:1;padding:0;}
.preset-edit:hover{background:rgba(59,130,246,0.3);color:#93c5fd;}
.preset-delete:hover{background:rgba(239,68,68,0.3);color:#fca5a5;}
.preset-empty{font-size:0.8rem;color:var(--muted);margin:0;}
@media(max-width:768px){.schedule-layout{flex-direction:column;}.schedule-sidebar{flex:1 1 auto;display:flex;gap:1rem;flex-wrap:wrap;}.day-tabs-wrapper,.quick-add-section{flex:1;min-width:180px;}.day-tabs{flex-direction:row;flex-wrap:wrap;}.quick-add-btns{flex-direction:row;flex-wrap:wrap;}}
.schedule-day-header{display:flex;align-items:center;flex-wrap:wrap;gap:0.5rem;background:linear-gradient(180deg,#131a26,#0c1018);color:#ffffff;padding:12px 16px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);font-weight:600;margin-bottom:1rem;}
.schedule-day-header small,.schedule-day-header span{color:#cbd5e1;}
.schedule-container,.schedule-wrapper{background:transparent !important;}
.badge{padding:0.25rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;margin-left:0.25rem;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
.muted{color:var(--muted);}
.modal-overlay{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;}
.modal-backdrop{position:absolute;inset:0;background:rgba(0,0,0,0.6);}
.modal-box{position:relative;background:var(--card);border:1px solid var(--border);border-radius:14px;padding:1.5rem;min-width:320px;max-width:420px;width:100%;}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.modal-header h3{margin:0;font-size:1.1rem;}
.modal-close{background:none;border:none;color:var(--muted);font-size:1.5rem;cursor:pointer;padding:0;}
.form-group{margin-bottom:1rem;}
.mt-1{margin-top:0.25rem;}
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

    var presetSelect=document.getElementById('preset_select');
    var titleInput=document.getElementById('title');
    if(presetSelect){
        presetSelect.addEventListener('change',function(){
            var opt=this.options[this.selectedIndex];
            if(this.value==='__custom__'){
                titleInput.style.display='block';
                titleInput.value='';
                titleInput.required=true;
            }else if(this.value){
                titleInput.value=this.value;
                titleInput.style.display='none';
                titleInput.required=true;
                if(opt.dataset.start)document.getElementById('start_time').value=opt.dataset.start;
                if(opt.dataset.end)document.getElementById('end_time').value=opt.dataset.end||'';
            }else{
                titleInput.value='';
                titleInput.style.display='none';
            }
        });
    }
    function openAddModal(preset){
        form.action='{{ route("admin.schedule.store") }}';
        form.querySelector('#formMethod').value='POST';
        document.getElementById('modalTitle').textContent=preset?'Program Ekle (Hızlı)':'Program Ekle';
        form.reset();
        form.querySelector('input[name="day_of_week"]').value='{{ $currentDay }}';
        form.querySelector('input[name="is_active"]').checked=true;
        document.getElementById('dj_id').value='';
        var programciEl=document.getElementById('programci_id');
        if(programciEl){programciEl.value='';}
        if(presetSelect){presetSelect.style.display='block';}
        if(titleInput){titleInput.style.display='none';}
        if(preset){
            if(presetSelect){
                presetSelect.value=preset.title||'';
                var opt=presetSelect.options[presetSelect.selectedIndex];
                if(opt&&opt.dataset){titleInput.value=preset.title;if(opt.dataset.start)document.getElementById('start_time').value=opt.dataset.start;if(opt.dataset.end)document.getElementById('end_time').value=opt.dataset.end||'';}
                else{titleInput.value=preset.title||'';document.getElementById('start_time').value=preset.start||'';document.getElementById('end_time').value=preset.end||'';}
            }else{titleInput.value=preset.title||'';document.getElementById('start_time').value=preset.start||'';document.getElementById('end_time').value=preset.end||'';}
        }
        openModal();
    }
    btnAdd&&btnAdd.addEventListener('click',function(){openAddModal();});
    document.querySelectorAll('.quick-add-btn').forEach(function(btn){
        btn.addEventListener('click',function(){
            openAddModal({
                title:this.dataset.preset,
                start:this.dataset.start,
                end:this.dataset.end
            });
        });
    });

    var presetModal=document.getElementById('presetModal');
    var presetForm=document.getElementById('presetForm');
    document.querySelectorAll('[data-close-preset-modal]').forEach(function(el){el.addEventListener('click',function(){if(presetModal)presetModal.style.display='none';});});
    document.getElementById('btnAddPreset')&&document.getElementById('btnAddPreset').addEventListener('click',function(){
        presetForm.action='{{ route("admin.schedule.presets.store") }}';
        presetForm.querySelector('#presetFormMethod').value='POST';
        document.getElementById('presetModalTitle').textContent='Preset Ekle';
        presetForm.reset();
        presetForm.querySelector('input[name="day"]').value='{{ $currentDay }}';
        if(presetModal)presetModal.style.display='flex';
    });
    document.querySelectorAll('.preset-edit').forEach(function(btn){
        btn.addEventListener('click',function(){
            var id=this.dataset.id;
            presetForm.action='{{ url("admin/schedule/presets") }}/'+id;
            presetForm.querySelector('#presetFormMethod').value='PUT';
            document.getElementById('presetModalTitle').textContent='Preset Düzenle';
            document.getElementById('preset_title').value=this.dataset.title||'';
            document.getElementById('preset_start').value=this.dataset.start||'';
            document.getElementById('preset_end').value=this.dataset.end||'';
            presetForm.querySelector('input[name="day"]').value='{{ $currentDay }}';
            if(presetModal)presetModal.style.display='flex';
        });
    });

    editBtns.forEach(function(btn){
        btn.addEventListener('click',function(){
            var id=btn.dataset.edit;
            var title=btn.dataset.title;
            var description=btn.dataset.description||'';
            var djId=btn.dataset.djId||'';
            var programciId=btn.dataset.programciId||'';
            var start=btn.dataset.start||'';
            var end=btn.dataset.end||'';
            var active=btn.dataset.active==='1';
            form.action='{{ url("admin/schedule") }}/'+id;
            form.querySelector('#formMethod').value='PUT';
            document.getElementById('modalTitle').textContent='Program Düzenle';
            if(presetSelect){presetSelect.style.display='none';}
            if(titleInput){titleInput.style.display='block';titleInput.value=title;}
            var descEl=document.getElementById('description');
            if(descEl){descEl.value=description;}
            document.getElementById('dj_id').value=djId;
            var programciEl=document.getElementById('programci_id');
            if(programciEl){programciEl.value=programciId;}
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
