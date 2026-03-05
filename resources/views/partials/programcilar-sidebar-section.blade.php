@php
    $programcilar = $programcilar ?? collect();
@endphp
@if($programcilar->isNotEmpty())
<div class="container-fluid px-3 px-lg-4 mt-4 programcilar-sidebar-section">
@push('styles')
<style>
.programcilar-sidebar-section .programcilar-section { margin-top: 0; }
.programcilar-sidebar-section .sidebar-widget .listener-swiper-wrap { height: 100%; }
</style>
@endpush
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
