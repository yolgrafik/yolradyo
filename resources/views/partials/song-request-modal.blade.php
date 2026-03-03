<div id="songRequestModal" class="request-modal" aria-hidden="true">
    <div class="request-modal__backdrop" data-close-modal></div>
    <div class="request-modal__box">
        <button type="button" class="request-modal__close" data-close-modal aria-label="Kapat">&times;</button>
        <h3 class="request-modal__title">Şarkı İstek</h3>
        <form id="songRequestForm" class="request-form">
            @csrf
            <div class="request-form__group">
                <label for="isim_soyad">İsim Soyad *</label>
                <input type="text" name="isim_soyad" id="isim_soyad" required class="request-form__input">
                <span class="request-form__error" id="err_isim_soyad"></span>
            </div>
            <div class="request-form__group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" required class="request-form__input">
                <span class="request-form__error" id="err_email"></span>
            </div>
            <div class="request-form__group">
                <label for="sanatci_ismi">Sanatçı İsmi *</label>
                <input type="text" name="sanatci_ismi" id="sanatci_ismi" required class="request-form__input">
                <span class="request-form__error" id="err_sanatci_ismi"></span>
            </div>
            <div class="request-form__group">
                <label for="turku_ismi">Türkü İsmi *</label>
                <input type="text" name="turku_ismi" id="turku_ismi" required class="request-form__input">
                <span class="request-form__error" id="err_turku_ismi"></span>
            </div>
            <div class="request-form__group">
                <label for="mesaj">Mesaj (opsiyonel)</label>
                <textarea name="mesaj" id="mesaj" rows="3" class="request-form__input"></textarea>
                <span class="request-form__error" id="err_mesaj"></span>
            </div>
            <div class="request-form__success" id="formSuccess" style="display:none">İsteğiniz alındı.</div>
            <div class="request-form__actions">
                <button type="submit" class="request-form__btn">Gönder</button>
                <button type="button" class="request-form__btn request-form__btn--cancel" data-close-modal>İptal</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.request-modal{position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;-webkit-overflow-scrolling:touch;}
.request-modal.is-open{display:flex;}
.request-modal__backdrop{position:absolute;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);}
.request-modal__box{position:relative;background:rgba(22,28,36,0.95);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:1.5rem;max-width:420px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.5),0 0 0 1px rgba(255,255,255,0.05) inset;margin:auto;}
.request-modal__close{position:absolute;top:1rem;right:1rem;background:none;border:none;color:var(--muted);font-size:1.5rem;cursor:pointer;line-height:1;padding:0.25rem;}
.request-modal__close:hover{color:var(--text);}
.request-modal__title{font-size:1.25rem;font-weight:700;margin-bottom:1.25rem;color:var(--text);}
.request-form__group{margin-bottom:1rem;}
.request-form__group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.35rem;}
.request-form__input{width:100%;padding:0.65rem 0.9rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);}
.request-form__input:focus{outline:none;border-color:var(--accent);}
.request-form__error{font-size:0.8rem;color:#f87171;margin-top:0.25rem;display:block;}
.request-form__success{padding:0.75rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:8px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.request-form__actions{display:flex;gap:0.75rem;margin-top:1.25rem;}
.request-form__btn{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;border-radius:8px;cursor:pointer;border:none;}
.request-form__btn[type=submit]{background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;}
.request-form__btn--cancel{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
@media(max-width:480px){.request-modal{padding:0.5rem;}.request-modal__box{padding:1.25rem;max-height:85vh;}}
</style>
@endpush

@push('scripts')
<script>
(function(){
    var modal=document.getElementById('songRequestModal');
    var form=document.getElementById('songRequestForm');
    var closeBtns=document.querySelectorAll('[data-close-modal]');
    var successEl=document.getElementById('formSuccess');
    function openModal(){if(modal){modal.classList.add('is-open');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';}}
    function closeModal(){if(modal){modal.classList.remove('is-open');modal.setAttribute('aria-hidden','true');document.body.style.overflow='';}}
    document.addEventListener('click',function(e){
        var t=e.target;
        while(t){
            if(t.getAttribute&&t.getAttribute('data-open-song-request')!==null){e.preventDefault();openModal();return;}
            t=t.parentElement;
        }
    });
    closeBtns.forEach(function(btn){btn.addEventListener('click',closeModal);});
    if(modal){modal.addEventListener('click',function(e){if(e.target===modal){closeModal();}});}
    document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal&&modal.classList.contains('is-open')){closeModal();}});
    function clearErrors(){['isim_soyad','email','sanatci_ismi','turku_ismi','mesaj'].forEach(function(id){var el=document.getElementById('err_'+id);if(el){el.textContent='';}});}
    if(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();
            clearErrors();
            successEl.style.display='none';
            var fd=new FormData(form);
            fd.append('_token',document.querySelector('input[name="_token"]').value);
            fetch('{{ route("song.request") }}',{
                method:'POST',
                body:fd,
                headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}
            }).then(function(r){return r.json();}).then(function(data){
                if(data.success){successEl.style.display='block';form.reset();setTimeout(closeModal,1500);}
                else if(data.errors){Object.keys(data.errors).forEach(function(k){var m=data.errors[k][0];var errEl=document.getElementById('err_'+k);if(errEl){errEl.textContent=m;}});}
            }).catch(function(){successEl.textContent='Bir hata oluştu. Lütfen tekrar deneyin.';successEl.style.background='rgba(239,68,68,0.2)';successEl.style.color='#fca5a5';successEl.style.display='block';});
        });
    }
})();
</script>
@endpush
