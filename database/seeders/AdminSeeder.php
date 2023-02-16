<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run()
	{
		Admin::create([
			'name' => 'Elyric Admin',
			'email' => 'elyric@admin.com',
			'password' => bcrypt('password123'),
		]);
	}
}
