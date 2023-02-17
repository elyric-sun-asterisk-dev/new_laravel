<?php

namespace App\Models;
use App\Models\User;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakenCategory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'taken', 'score', 'total'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
