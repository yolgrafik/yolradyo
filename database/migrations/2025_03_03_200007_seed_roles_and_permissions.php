<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            ['key' => 'news.view', 'label' => 'Haber Görüntüleme'],
            ['key' => 'news.create', 'label' => 'Haber Oluşturma'],
            ['key' => 'news.edit', 'label' => 'Haber Düzenleme'],
            ['key' => 'news.delete', 'label' => 'Haber Silme'],
            ['key' => 'settings.manage', 'label' => 'Ayarlar Yönetimi'],
            ['key' => 'users.manage', 'label' => 'Kullanıcı Yönetimi'],
            ['key' => 'ads.manage', 'label' => 'Reklam Yönetimi'],
            ['key' => 'messages.moderate', 'label' => 'Mesaj Moderasyon'],
            ['key' => 'logs.view', 'label' => 'Aktivite Logları Görüntüleme'],
        ];

        foreach ($permissions as $p) {
            DB::table('permissions')->insertOrIgnore([
                'key' => $p['key'],
                'label' => $p['label'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $superAdminId = DB::table('roles')->insertGetId([
            'name' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permIds = DB::table('permissions')->pluck('id');
        foreach ($permIds as $pid) {
            DB::table('role_permission')->insert([
                'role_id' => $superAdminId,
                'permission_id' => $pid,
            ]);
        }

        DB::table('roles')->insert([
            ['name' => 'Editor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Moderator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DJ', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('role_permission')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
    }
};
