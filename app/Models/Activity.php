<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id','activitiable_id','activitiable_type'];

    public function activitiable()
    {
      return $this->morphTo();
    }
}
