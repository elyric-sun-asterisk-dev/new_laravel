<?php

namespace App\Traits;

use App\Models\Activity;
use Auth;

trait HasActivity
{
    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitiable');
    }

    public function logActivity(string $description)
    {
        $this->activities()->create(['description' => $description, 'user_id' => Auth::id()]);
    }
    
}
