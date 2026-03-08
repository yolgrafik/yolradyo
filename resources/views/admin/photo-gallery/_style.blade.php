@push('styles')
<style>
.pg-card{max-width:980px;}
.pg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;}
.pg-item{background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;overflow:hidden;}
.pg-item img{width:100%;aspect-ratio:4/3;object-fit:cover;display:block;}
.pg-item__body{padding:10px;}
.pg-form-group{margin-bottom:1rem;}
.pg-form-group label{display:block;margin-bottom:.4rem;font-weight:600;font-size:.88rem;}
.pg-input{width:100%;padding:.7rem .9rem;background:rgba(255,255,255,.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.pg-actions{display:flex;gap:.6rem;margin-top:1rem;flex-wrap:wrap;}
.pg-alert{padding:.7rem .9rem;border-radius:10px;margin-bottom:.8rem;font-size:.86rem;}
.pg-alert--ok{background:rgba(34,197,94,.2);border:1px solid rgba(34,197,94,.35);color:#86efac;}
</style>
@endpush
