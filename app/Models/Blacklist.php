<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $table = 'blacklist';

    protected $fillable = ['type', 'value', 'reason'];

    public static function isBlocked(?string $fullName, ?string $email = null): bool
    {
        $fullName = $fullName ? trim($fullName) : null;
        $email = $email ? trim(strtolower($email)) : null;

        if ($fullName) {
            $exists = static::where('type', 'name')
                ->whereRaw('LOWER(TRIM(value)) = ?', [strtolower($fullName)])
                ->exists();
            if ($exists) {
                return true;
            }
        }

        if ($email) {
            $exists = static::where('type', 'email')
                ->whereRaw('LOWER(TRIM(value)) = ?', [$email])
                ->exists();
            if ($exists) {
                return true;
            }
        }

        return false;
    }
}
