<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Services\LiveDjService;

class FrontendController extends Controller
{
    public function home(LiveDjService $liveDjService)
    {
        $sliders = Slider::active()->ordered()->get();
        $liveDj = $liveDjService->getLiveDj();

        return view('frontend.home', compact('sliders', 'liveDj'));
    }

    public function programlar()
    {
        return view('frontend.page', ['pageTitle' => 'Programlar']);
    }

    public function haberler()
    {
        return view('frontend.page', ['pageTitle' => 'Haberler']);
    }

    public function videolar()
    {
        return view('frontend.page', ['pageTitle' => 'Video Galeri']);
    }

    public function galeri()
    {
        return view('frontend.page', ['pageTitle' => 'Foto Galeri']);
    }

    public function reklam()
    {
        return view('frontend.page', ['pageTitle' => 'Reklam & Isbirligi']);
    }

    public function hakkimizda(string $slug)
    {
        $titles = [
            'biz-kimiz' => 'Biz Kimiz',
            'misyon' => 'Misyon & Vizyon',
            'politika' => 'Yayin Politikamiz',
        ];
        $pageTitle = $titles[$slug] ?? 'Hakkimizda';
        return view('frontend.page', ['pageTitle' => $pageTitle]);
    }

    public function iletisim()
    {
        return view('frontend.page', ['pageTitle' => 'Iletisim']);
    }

    public function gizlilik()
    {
        return view('frontend.page', ['pageTitle' => 'Gizlilik Politikasi']);
    }

    public function cerez()
    {
        return view('frontend.page', ['pageTitle' => 'Cerez Politikasi']);
    }

    public function kullanim()
    {
        return view('frontend.page', ['pageTitle' => 'Kullanim Sartlari']);
    }

    public function kvkk()
    {
        return view('frontend.page', ['pageTitle' => 'KVKK Aydinlatma Metni']);
    }
}
