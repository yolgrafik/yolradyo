<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabaseCommand extends Command
{
    protected $signature = 'db:export {--output=database/full-export.sql : Output file path}';
    protected $description = 'Export full database to SQL file (for cPanel deployment)';

    public function handle(): int
    {
        $output = $this->option('output');
        $fullPath = base_path($output);

        $driver = config('database.default');
        if ($driver !== 'mysql') {
            $this->error('Sadece MySQL destekleniyor.');
            return 1;
        }

        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $mysqldump = $this->findMysqldump();
        if (!$mysqldump) {
            $this->warn('mysqldump bulunamadi. Alternatif: PHP ile tablo tablo export denenecek.');
            return $this->exportViaPhp($fullPath);
        }

        $passArg = $password ? '-p' . escapeshellarg($password) : '';
        $cmd = sprintf(
            '%s -h %s -P %s -u %s %s %s --single-transaction --routines --triggers --set-charset --default-character-set=utf8mb4 2>nul',
            escapeshellcmd($mysqldump),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $passArg,
            escapeshellarg($database)
        );
        $result = shell_exec($cmd);
        if ($result && strlen(trim($result)) > 100) {
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($fullPath, $result);
            $this->info("Veritabani export edildi: {$output}");
            return 0;
        }
        return $this->exportViaPhp($fullPath);
    }

    private function findMysqldump(): ?string
    {
        $paths = ['mysqldump'];
        if (PHP_OS_FAMILY === 'Windows') {
            $laragon = getenv('LARAGON_ROOT') ?: 'C:\\laragon';
            $glob = $laragon . '\\bin\\mysql\\*\\bin\\mysqldump.exe';
            $found = glob($glob);
            if (!empty($found)) {
                $paths = array_merge($paths, $found);
            }
        }
        foreach ($paths as $p) {
            $out = [];
            exec(escapeshellcmd($p) . ' --version 2>nul', $out, $r);
            if ($r === 0) return $p;
        }
        return null;
    }

    private function exportViaPhp(string $fullPath): int
    {
        $dir = dirname($fullPath);
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $tables = DB::select('SHOW TABLES');
        $dump = "-- RadyoYol Full Export\n-- " . now() . "\nSET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            $dump .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $create = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $createSql = array_values((array) $create)[1];
            $dump .= $createSql . ";\n\n";

            $rows = DB::table($tableName)->get();
            if ($rows->isEmpty()) continue;

            $cols = array_keys((array) $rows->first());
            $colList = '`' . implode('`,`', $cols) . '`';

            foreach ($rows->chunk(50) as $chunk) {
                $vals = [];
                foreach ($chunk as $row) {
                    $arr = (array) $row;
                    $v = [];
                    foreach ($cols as $col) {
                        $c = $arr[$col] ?? null;
                        $v[] = $c === null ? 'NULL' : "'" . str_replace(["\\", "'", "\r", "\n"], ["\\\\", "''", '\\r', '\\n'], (string) $c) . "'";
                    }
                    $vals[] = '(' . implode(',', $v) . ')';
                }
                $dump .= "INSERT INTO `{$tableName}` ({$colList}) VALUES\n" . implode(",\n", $vals) . ";\n\n";
            }
        }
        $dump .= "SET FOREIGN_KEY_CHECKS=1;\n";
        file_put_contents($fullPath, $dump);
        $this->info("PHP ile export edildi: " . basename($fullPath));
        return 0;
    }
}
