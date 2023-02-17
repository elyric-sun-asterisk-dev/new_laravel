<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	public function run()
	{
		for($i=0;$i<20;$i++){
			$title = "Lesson " . ($i + 1);
        	$description = "Description for " . $title;
			$taken = 0;

        	Category::create([
            	'title' => $title,
            	'description' => $description
        	]);
		}
	}
}
