<?php

namespace App\Models;

use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
	protected $fillable = ['answer', 'is_correct', 'choice_id'];

	public function choices()
	{
		return $this->belongsTo(Choice::class);
	}
}
