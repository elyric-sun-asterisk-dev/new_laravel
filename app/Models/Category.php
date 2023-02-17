<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivity;

class Category extends Model
{
    use HasFactory, HasActivity;

	protected $fillable = ['title', 'description'];

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
