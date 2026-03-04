<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class AdminTwoFactor extends Model
{
    protected $table = 'admin_two_factor';

    protected $fillable = [
        'admin_id',
        'enabled',
        'secret',
        'recovery_codes',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'recovery_codes' => 'array',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function getDecryptedSecret(): ?string
    {
        return $this->secret ? Crypt::decryptString($this->secret) : null;
    }

    public function setEncryptedSecret(string $secret): void
    {
        $this->secret = Crypt::encryptString($secret);
        $this->save();
    }
}
