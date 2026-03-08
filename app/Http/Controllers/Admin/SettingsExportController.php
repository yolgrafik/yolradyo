<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SettingsExportController extends Controller
{
    public function __invoke(): Response
    {
        if (!session('admin_logged_in')) {
            abort(403);
        }

        $sql = $this->buildSettingsSql();
        $filename = 'ayarlar_' . date('Y-m-d_H-i') . '.sql';

        return response($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    private function buildSettingsSql(): string
    {
        $lines = [
            '-- RadyoYol Tüm Ayarlar Export',
            '-- Oluşturulma: ' . now()->format('Y-m-d H:i:s'),
            '-- Kullanım: mysql -u kullanici -p veritabani < ayarlar_xxx.sql',
            '',
            'SET NAMES utf8mb4;',
            'SET FOREIGN_KEY_CHECKS = 0;',
            '',
        ];

        if (Schema::hasTable('settings')) {
            $rows = DB::table('settings')->get();
            if ($rows->isNotEmpty()) {
                $lines[] = '-- settings (radyo/shoutcast)';
                $lines[] = 'TRUNCATE TABLE `settings`;';
                foreach ($rows as $row) {
                    $cols = ['radio_stream_url', 'radio_backup_stream_url', 'radio_auto_play', 'radio_default_volume', 'shoutcast_base_url', 'shoutcast_sid'];
                    if (Schema::hasColumn('settings', 'radio_force_status')) {
                        $cols[] = 'radio_force_status';
                    }
                    $cols[] = 'created_at';
                    $cols[] = 'updated_at';
                    $vals = [];
                    foreach ($cols as $c) {
                        $v = $row->{$c} ?? null;
                        $vals[] = $this->sqlVal($v);
                    }
                    $lines[] = 'INSERT INTO `settings` (`' . implode('`, `', $cols) . '`) VALUES (' . implode(', ', $vals) . ');';
                }
                $lines[] = '';
            }
        }

        if (Schema::hasTable('site_settings')) {
            $rows = DB::table('site_settings')->get();
            if ($rows->isNotEmpty()) {
                $lines[] = '-- site_settings (genel site ayarları)';
                $lines[] = 'DELETE FROM `site_settings`;';
                foreach ($rows as $row) {
                    $lines[] = 'INSERT INTO `site_settings` (`key`, `value`, `type`, `created_at`, `updated_at`) VALUES (' .
                        $this->sqlVal($row->key) . ', ' . $this->sqlVal($row->value) . ', ' . $this->sqlVal($row->type ?? 'text') . ', ' .
                        $this->sqlVal($row->created_at) . ', ' . $this->sqlVal($row->updated_at) . ');';
                }
                $lines[] = '';
            }
        }

        if (Schema::hasTable('site_theme_settings')) {
            $rows = DB::table('site_theme_settings')->get();
            if ($rows->isNotEmpty()) {
                $lines[] = '-- site_theme_settings (tema renk paleti)';
                $lines[] = 'TRUNCATE TABLE `site_theme_settings`;';
                foreach ($rows as $row) {
                    $cols = array_keys((array) $row);
                    $vals = [];
                    foreach ($cols as $c) {
                        $vals[] = $this->sqlVal($row->{$c} ?? null);
                    }
                    $lines[] = 'INSERT INTO `site_theme_settings` (`' . implode('`, `', $cols) . '`) VALUES (' . implode(', ', $vals) . ');';
                }
                $lines[] = '';
            }
        }

        if (Schema::hasTable('site_theme')) {
            $rows = DB::table('site_theme')->get();
            if ($rows->isNotEmpty()) {
                $lines[] = '-- site_theme (arka plan, buton renkleri vb.)';
                $lines[] = 'TRUNCATE TABLE `site_theme`;';
                foreach ($rows as $row) {
                    $cols = array_keys((array) $row);
                    $vals = [];
                    foreach ($cols as $c) {
                        $vals[] = $this->sqlVal($row->{$c} ?? null);
                    }
                    $lines[] = 'INSERT INTO `site_theme` (`' . implode('`, `', $cols) . '`) VALUES (' . implode(', ', $vals) . ');';
                }
                $lines[] = '';
            }
        }

        $lines[] = 'SET FOREIGN_KEY_CHECKS = 1;';
        $lines[] = '';

        return implode("\n", $lines);
    }

    private function sqlVal(mixed $v): string
    {
        if ($v === null) {
            return 'NULL';
        }
        if (is_bool($v)) {
            return $v ? '1' : '0';
        }
        if (is_numeric($v) && !is_string($v)) {
            return (string) $v;
        }
        $s = (string) $v;
        $s = str_replace(['\\', "'", "\r", "\n"], ['\\\\', "''", '\\r', '\\n'], $s);
        return "'" . $s . "'";
    }
}
