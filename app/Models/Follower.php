<?php

namespace App\Models;
use App\Models\User;
use App\Traits\HasActivity;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory, HasActivity;

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
    
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
