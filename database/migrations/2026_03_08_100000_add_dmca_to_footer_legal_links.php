<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $row = DB::table('site_settings')->where('key', 'footer_legal_links_json')->first();
        if (!$row) {
            return;
        }
        $links = json_decode($row->value, true);
        if (!is_array($links)) {
            return;
        }
        $hasDmca = collect($links)->contains(fn ($l) => ($l['url'] ?? '') === '/dmca');
        if ($hasDmca) {
            return;
        }
        $newLinks = [];
        $dmcaAdded = false;
        foreach ($links as $item) {
            if (!$dmcaAdded && ($item['url'] ?? '') === '/kvkk') {
                $newLinks[] = ['label' => 'DMCA / Telif Hakkı Bildirimi', 'url' => '/dmca'];
                $dmcaAdded = true;
            }
            $newLinks[] = $item;
        }
        if (!$dmcaAdded) {
            $newLinks[] = ['label' => 'DMCA / Telif Hakkı Bildirimi', 'url' => '/dmca'];
        }
        DB::table('site_settings')->where('key', 'footer_legal_links_json')->update([
            'value' => json_encode($newLinks),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\Cache::forget('site_settings_all');
        \Illuminate\Support\Facades\Cache::forget('site_settings_footer_legal_links_json');
    }

    public function down(): void
    {
        $row = DB::table('site_settings')->where('key', 'footer_legal_links_json')->first();
        if (!$row) {
            return;
        }
        $links = json_decode($row->value, true);
        if (!is_array($links)) {
            return;
        }
        $newLinks = array_values(array_filter($links, fn ($l) => ($l['url'] ?? '') !== '/dmca'));
        DB::table('site_settings')->where('key', 'footer_legal_links_json')->update([
            'value' => json_encode($newLinks),
            'updated_at' => now(),
        ]);
    }
};
