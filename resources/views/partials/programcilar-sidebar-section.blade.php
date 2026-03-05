@php
    $programcilar = $programcilar ?? collect();
@endphp
@if($programcilar->isNotEmpty())
<div class="container-fluid px-3 px-lg-4 mt-4">
    <div class="row g-4 align-items-stretch">
        {{-- Left: Programcılar --}}
        <div class="col-12 col-lg-8">
            <div class="h-100">
                @include('partials.programcilar-cards')
            </div>
        </div>
        {{-- Right: Dinleyicilerden Gelenler --}}
        <div class="col-12 col-lg-4 d-flex">
            @include('partials.listener-submissions-widget', ['sidebarMode' => true])
        </div>
    </div>
</div>
@endif
