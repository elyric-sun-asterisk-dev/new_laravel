<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Choice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

	protected $fillable = ['question', 'category_id'];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function choices()
	{
		return $this->hasMany(Choice::class);
	}
}
