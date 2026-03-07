<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('status', 'pending')->update(['status' => 'pasif']);
        DB::table('users')->where('status', 'approved')->update(['status' => 'aktif']);
        DB::table('users')->where('status', 'rejected')->update(['status' => 'ban']);
    }

    public function down(): void
    {
        DB::table('users')->where('status', 'pasif')->update(['status' => 'pending']);
        DB::table('users')->where('status', 'aktif')->update(['status' => 'approved']);
        DB::table('users')->where('status', 'ban')->update(['status' => 'rejected']);
    }
};
