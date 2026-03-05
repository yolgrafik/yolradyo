<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsSeeder extends Seeder
{
    public function run(): void
    {
        $header = [
            ['title' => 'Anasayfa', 'type' => 'page', 'url' => '/', 'sort_order' => 0],
            ['title' => 'Programlar', 'type' => 'page', 'url' => '/programlar', 'sort_order' => 1],
            ['title' => 'Haberler', 'type' => 'page', 'url' => '/haberler', 'sort_order' => 2],
            ['title' => 'Medya', 'type' => 'page', 'url' => '/videolar', 'sort_order' => 3],
            ['title' => 'Sponsor', 'type' => 'page', 'url' => '/reklam', 'sort_order' => 4],
            ['title' => 'Hakkimizda', 'type' => 'page', 'url' => '/hakkimizda/biz-kimiz', 'sort_order' => 5],
            ['title' => 'Iletisim', 'type' => 'page', 'url' => '/iletisim', 'sort_order' => 6],
        ];

        foreach ($header as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'header', 'title' => $item['title'], 'parent_id' => null],
                array_merge($item, ['location' => 'header', 'parent_id' => null, 'target_blank' => false, 'is_active' => true])
            );
        }

        $medya = MenuItem::where('location', 'header')->where('title', 'Medya')->whereNull('parent_id')->first();
        if ($medya) {
            $mediaSubs = [
                ['title' => 'Video Galeri', 'url' => '/videolar', 'sort_order' => 0],
                ['title' => 'Foto Galeri', 'url' => '/galeri', 'sort_order' => 1],
            ];
            foreach ($mediaSubs as $s) {
                MenuItem::updateOrCreate(
                    ['location' => 'header', 'title' => $s['title'], 'parent_id' => $medya->id],
                    array_merge($s, ['location' => 'header', 'type' => 'page', 'parent_id' => $medya->id, 'target_blank' => false, 'is_active' => true])
                );
            }
        }

        $hakkimizda = MenuItem::where('location', 'header')->where('title', 'Hakkimizda')->first();
        if ($hakkimizda) {
            $subs = [
                ['title' => 'Biz Kimiz', 'url' => '/hakkimizda/biz-kimiz', 'sort_order' => 0],
                ['title' => 'Misyon & Vizyon', 'url' => '/hakkimizda/misyon', 'sort_order' => 1],
                ['title' => 'Yayin Politikamiz', 'url' => '/hakkimizda/politika', 'sort_order' => 2],
            ];
            foreach ($subs as $s) {
                MenuItem::updateOrCreate(
                    ['location' => 'header', 'title' => $s['title'], 'parent_id' => $hakkimizda->id],
                    array_merge($s, ['location' => 'header', 'type' => 'page', 'parent_id' => $hakkimizda->id, 'target_blank' => false, 'is_active' => true])
                );
            }
        }

        $footer = [
            ['title' => 'Gizlilik Politikasi', 'type' => 'page', 'url' => '/gizlilik', 'sort_order' => 0],
            ['title' => 'Cerez Politikasi', 'type' => 'page', 'url' => '/cerez', 'sort_order' => 1],
            ['title' => 'Kullanim Sartlari', 'type' => 'page', 'url' => '/kullanim', 'sort_order' => 2],
            ['title' => 'KVKK Aydinlatma Metni', 'type' => 'page', 'url' => '/kvkk', 'sort_order' => 3],
        ];

        foreach ($footer as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'footer', 'title' => $item['title'], 'parent_id' => null],
                array_merge($item, ['location' => 'footer', 'parent_id' => null, 'target_blank' => false, 'is_active' => true])
            );
        }
    }
}
