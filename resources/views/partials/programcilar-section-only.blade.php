@php
    $programcilar = $programcilar ?? collect();
@endphp
@if($programcilar->isNotEmpty())
<div class="container-fluid px-3 px-lg-4 mt-4">
    @include('partials.programcilar-cards')
</div>
@endif
