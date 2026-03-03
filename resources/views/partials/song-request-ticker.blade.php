@php
    $approvedRequests = $approvedSongRequests ?? collect();
    $sepUrl = file_exists(public_path('logo.png')) ? asset('logo.png') : (file_exists(public_path('assets/images/play.png')) ? asset('assets/images/play.png') : asset('assets/images/play.svg'));
@endphp
@push('styles')
<style>
.request-ticker-wrap{background:rgba(0,0,0,0.25);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:0.5rem 0;overflow:hidden;}
.request-ticker{overflow:hidden;white-space:nowrap;}
.request-ticker__track{display:inline-flex;align-items:center;gap:1.5rem;animation:requestTickerMarquee 40s linear infinite;}
.request-ticker[data-pause-on-hover]:hover .request-ticker__track{animation-play-state:paused;}
.request-ticker__item{font-size:0.95rem;color:var(--text);}
.request-ticker__sep{width:24px;height:24px;object-fit:contain;flex-shrink:0;opacity:0.8;}
@keyframes requestTickerMarquee{0%{transform:translateX(0);}100%{transform:translateX(-50%);}}
@media(max-width:768px){.request-ticker__item{font-size:0.85rem;}.request-ticker__sep{width:20px;height:20px;}}
</style>
@endpush
@if($approvedRequests->isNotEmpty())
<div class="request-ticker-wrap">
    <div class="request-ticker" data-pause-on-hover>
        <div class="request-ticker__track">
            @foreach($approvedRequests as $req)
            <span class="request-ticker__item">{{ e($req->full_name) }}: {{ e($req->artist_name) }} - {{ e($req->song_name) }}</span>
            <img src="{{ $sepUrl }}" alt="" class="request-ticker__sep">
            @endforeach
            @foreach($approvedRequests as $req)
            <span class="request-ticker__item">{{ e($req->full_name) }}: {{ e($req->artist_name) }} - {{ e($req->song_name) }}</span>
            <img src="{{ $sepUrl }}" alt="" class="request-ticker__sep">
            @endforeach
        </div>
    </div>
</div>
@endif
