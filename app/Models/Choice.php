<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
	protected $fillable = ['choiceA','choiceB','choiceC','choiceD', 'question_id'];

	public function question()
	{
		return $this->belongsTo(Question::class);
	}
	public function answer()
	{
		return $this->hasOne(Answer::class);
	}
}
