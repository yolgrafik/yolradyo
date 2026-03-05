<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Video Galeri ve Foto Galeri'yi "Medya" başlığı altında toplar.
     */
    public function up(): void
    {
        $videoGaleri = DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where(function ($q) {
                $q->where('title', 'Video Galeri')
                    ->orWhere('title', 'like', 'Video Galeri%');
            })
            ->first();

        $fotoGaleri = DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where(function ($q) {
                $q->where('title', 'Foto Galeri')
                    ->orWhere('title', 'like', 'Foto Galeri%');
            })
            ->first();

        if (!$videoGaleri || !$fotoGaleri) {
            return;
        }

        $sortOrder = min((int) $videoGaleri->sort_order, (int) $fotoGaleri->sort_order);

        $medyaId = DB::table('menu_items')->insertGetId([
            'location' => 'header',
            'title' => 'Medya',
            'type' => 'page',
            'url' => '/videolar',
            'parent_id' => null,
            'sort_order' => $sortOrder,
            'target_blank' => 0,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menu_items')
            ->where('id', $videoGaleri->id)
            ->update([
                'parent_id' => $medyaId,
                'sort_order' => 0,
                'title' => 'Video Galeri',
                'url' => '/videolar',
                'updated_at' => now(),
            ]);

        DB::table('menu_items')
            ->where('id', $fotoGaleri->id)
            ->update([
                'parent_id' => $medyaId,
                'sort_order' => 1,
                'title' => 'Foto Galeri',
                'url' => '/galeri',
                'updated_at' => now(),
            ]);

        $otherItems = DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->whereNotIn('id', [$medyaId])
            ->orderBy('sort_order')
            ->get();

        $order = 0;
        foreach ($otherItems as $item) {
            DB::table('menu_items')
                ->where('id', $item->id)
                ->update(['sort_order' => $order++, 'updated_at' => now()]);
        }
    }

    /**
     * Reverse: Medya'yı kaldır, Video Galeri ve Foto Galeri'yi tekrar üst seviyeye al.
     */
    public function down(): void
    {
        $medya = DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where('title', 'Medya')
            ->first();

        if (!$medya) {
            return;
        }

        $children = DB::table('menu_items')
            ->where('parent_id', $medya->id)
            ->orderBy('sort_order')
            ->get();

        $sortOrder = (int) $medya->sort_order;
        foreach ($children as $child) {
            DB::table('menu_items')
                ->where('id', $child->id)
                ->update([
                    'parent_id' => null,
                    'sort_order' => $sortOrder++,
                    'updated_at' => now(),
                ]);
        }

        DB::table('menu_items')->where('id', $medya->id)->delete();

        $otherItems = DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $order = 0;
        foreach ($otherItems as $item) {
            DB::table('menu_items')
                ->where('id', $item->id)
                ->update(['sort_order' => $order++, 'updated_at' => now()]);
        }
    }
};
