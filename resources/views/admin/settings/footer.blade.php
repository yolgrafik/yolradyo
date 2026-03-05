@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-header">Footer Yonetimi</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.footer') }}" id="footerForm">
            @csrf

            <div class="form-group">
                <label for="footer_legal_text">Yasal Metin *</label>
                <input type="text" name="footer_legal_text" id="footer_legal_text" required
                    value="{{ old('footer_legal_text', $footer_legal_text ?? 'Radyoyol Tum Haklari Saklidir') }}"
                    placeholder="Radyoyol Tum Haklari Saklidir">
                @error('footer_legal_text')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Footer Linkleri</label>
                <p class="muted" style="font-size: 0.85rem; margin-bottom: 0.75rem;">Her satir: label|url (ornek: Gizlilik Politikasi|/gizlilik)</p>
                <div id="footerLinksContainer">
                    @foreach($footer_legal_links ?? [] as $idx => $link)
                    <div class="link-row" data-index="{{ $idx }}">
                        <input type="text" class="link-label" placeholder="Etiket" value="{{ $link['label'] ?? '' }}">
                        <input type="text" class="link-url" placeholder="/url" value="{{ $link['url'] ?? '' }}">
                        <button type="button" class="btn-remove" title="Kaldir">&times;</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="addLinkBtn" class="btn-add">+ Link Ekle</button>
                <input type="hidden" name="footer_legal_links_json" id="footer_legal_links_json" value="">
                @error('footer_legal_links_json')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-group input[type="text"] { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.link-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: center; }
.link-row .link-label { flex: 1; }
.link-row .link-url { flex: 1; }
.link-row .btn-remove { width: 36px; height: 36px; background: rgba(239,68,68,0.3); color: #f87171; border: 1px solid rgba(239,68,68,0.5); border-radius: 8px; cursor: pointer; font-size: 1.2rem; line-height: 1; }
.link-row .btn-remove:hover { background: rgba(239,68,68,0.5); }
.btn-add { padding: 0.5rem 1rem; font-size: 0.85rem; background: rgba(255,255,255,0.08); color: var(--text); border: 1px solid var(--border); border-radius: 8px; cursor: pointer; margin-top: 0.5rem; }
.btn-add:hover { background: rgba(255,255,255,0.12); }
.muted { color: var(--muted); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    var container = document.getElementById('footerLinksContainer');
    var addBtn = document.getElementById('addLinkBtn');
    var hiddenInput = document.getElementById('footer_legal_links_json');
    var form = document.getElementById('footerForm');

    function addRow(label, url) {
        var idx = container.querySelectorAll('.link-row').length;
        var row = document.createElement('div');
        row.className = 'link-row';
        row.dataset.index = idx;
        row.innerHTML = '<input type="text" class="link-label" placeholder="Etiket" value="' + (label || '') + '">' +
            '<input type="text" class="link-url" placeholder="/url" value="' + (url || '') + '">' +
            '<button type="button" class="btn-remove" title="Kaldir">&times;</button>';
        container.appendChild(row);
        row.querySelector('.btn-remove').addEventListener('click', function() {
            row.remove();
        });
    }

    if (addBtn) addBtn.addEventListener('click', function() { addRow('', ''); });

    if (container.querySelectorAll('.link-row').length === 0) {
        addRow('Gizlilik Politikası', '/gizlilik');
        addRow('Çerez Politikası', '/cerez');
        addRow('Kullanım Şartları', '/kullanim');
        addRow('DMCA / Telif Hakkı Bildirimi', '/dmca');
        addRow('KVKK Aydınlatma Metni', '/kvkk');
    }

    form.addEventListener('submit', function(e) {
        var rows = container.querySelectorAll('.link-row');
        var arr = [];
        rows.forEach(function(row) {
            var label = row.querySelector('.link-label').value.trim();
            var url = row.querySelector('.link-url').value.trim();
            if (label && url) {
                arr.push({ label: label, url: url });
            }
        });
        hiddenInput.value = JSON.stringify(arr);
    });
})();
</script>
@endpush
@endsection
