<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Illuminate\Support\Facades\DB::unprepared("ALTER TABLE schedules CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
Illuminate\Support\Facades\DB::unprepared("UPDATE schedules SET title = 'Öğle Yayını' WHERE title = 'İöğle Yayını' OR title LIKE '├û─şle Yay%'");
Illuminate\Support\Facades\DB::unprepared("UPDATE schedules SET title = 'Öğleden Sonra' WHERE title = 'İöğleden Sonra' OR title LIKE '├û─şleden Sonra%'");
Illuminate\Support\Facades\DB::unprepared("UPDATE schedules SET title = 'Akşam Kuşağı' WHERE title LIKE 'Ak┼şam Ku┼şa%' OR title = 'Akşam Kuşağı'");
Illuminate\Support\Facades\DB::unprepared("UPDATE schedules SET title = 'Yöresel Halaylar' WHERE title = 'Y├Âresel Halaylar' OR title = 'Yöresel Halaylar'");

echo "ok" . PHP_EOL;
