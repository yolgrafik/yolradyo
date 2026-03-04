<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@radyoyol.com');
        $password = env('ADMIN_PASSWORD', 'admin123');
        $superAdminRoleId = DB::table('roles')->where('name', 'Super Admin')->value('id');

        if ($superAdminRoleId && !DB::table('admins')->where('email', $email)->exists()) {
            DB::table('admins')->insert([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => $superAdminRoleId,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Do not remove admin on rollback
    }
};
