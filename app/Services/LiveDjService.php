<?php

namespace App\Services;

use App\Models\DjProfile;

class LiveDjService
{
    /**
     * Get the currently live DJ for display.
     * Only returns DJ explicitly marked is_live=1 in admin.
     * When no one is CANLI, returns null (card shows "Şu an canlı yayın yok").
     */
    public function getLiveDj(): ?DjProfile
    {
        return DjProfile::live()->first();
    }
}
