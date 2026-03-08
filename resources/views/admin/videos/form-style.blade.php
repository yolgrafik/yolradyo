@push('styles')
<style>
.form-group{margin-bottom:1.2rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-input[type="file"]{padding:0.5rem;}
.checkbox-label{display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.9rem;font-weight:600;color:var(--text);}
.checkbox-label input{width:18px;height:18px;accent-color:var(--accent);}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;margin-bottom:1rem;}
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;margin-bottom:1rem;}
.preview-wrap{margin-top:0.75rem;max-width:280px;border-radius:10px;overflow:hidden;border:1px solid var(--border);}
.preview-img{display:block;width:100%;height:auto;object-fit:cover;}
.form-hint{font-size:0.8rem;color:var(--muted);margin-top:0.35rem;display:block;}
</style>
@endpush
