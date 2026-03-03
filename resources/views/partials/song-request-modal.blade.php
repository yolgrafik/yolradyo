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
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function(){
    var modal=document.getElementById('songRequestModal');
    var form=document.getElementById('songRequestForm');
    var openBtn=document.getElementById('openRequestModal');
    var closeBtns=document.querySelectorAll('[data-close-modal]');
    var successEl=document.getElementById('formSuccess');
    function openModal(){if(modal){modal.classList.add('is-open');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';}}
    function closeModal(){if(modal){modal.classList.remove('is-open');modal.setAttribute('aria-hidden','true');document.body.style.overflow='';}}
    if(openBtn){openBtn.addEventListener('click',function(e){e.preventDefault();openModal();});}
    document.addEventListener('click',function(e){
        var t=e.target;
        while(t){
            if(t.getAttribute&&t.getAttribute('data-open-song-request')!==null){e.preventDefault();openModal();return;}
            t=t.parentElement;
        }
    });
    closeBtns.forEach(function(btn){btn.addEventListener('click',closeModal);});
    if(modal){modal.addEventListener('click',function(e){if(e.target.classList&&e.target.classList.contains('request-modal__backdrop')){closeModal();}});}
    document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal&&modal.classList.contains('is-open')){closeModal();}});
    function clearErrors(){['isim_soyad','sanatci_ismi','turku_ismi','mesaj'].forEach(function(id){var el=document.getElementById('err_'+id);if(el){el.textContent='';}});}
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
                if(data.ok){successEl.textContent=data.message||'İsteğiniz alındı.';successEl.style.background='rgba(34,197,94,0.2)';successEl.style.color='#86efac';successEl.style.display='block';form.reset();setTimeout(closeModal,1500);}
                else if(data.errors){Object.keys(data.errors).forEach(function(k){var m=data.errors[k][0];var errEl=document.getElementById('err_'+k);if(errEl){errEl.textContent=m;}});}
            }).catch(function(){successEl.textContent='Bir hata oluştu. Lütfen tekrar deneyin.';successEl.style.background='rgba(239,68,68,0.2)';successEl.style.color='#fca5a5';successEl.style.display='block';});
        });
    }
})();
</script>
@endpush
