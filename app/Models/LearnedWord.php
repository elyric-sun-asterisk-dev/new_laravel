<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnedWord extends Model
{
    use HasFactory;
    protected $fillable = [ 'learned_from','learned_word', 'learned_answer', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
