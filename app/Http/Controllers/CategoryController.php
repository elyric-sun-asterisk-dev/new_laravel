<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
	{
		return Category::with([
			'questions', 
			'questions.choices', 
			'questions.choices.answer'
		])->get();
	}

	public function store(Request $request)
    {
        $validatedData = $request->validate([
			'title' => 'required|string',
			'description' => 'required|string'
		]);
		
		Category::create($validatedData);
	
		return response()->json([
			'message' => 'Category Successfully Added!'
		], 201);
    }

	public function show($categoryId)
	{
		return Category::with([
			'questions',
			'questions.choices',
			'questions.choices.answer'
		])->findOrFail($categoryId);
	}

	public function update(Request $request, $categoryId)
    {
        $request->validate([
			'title' => 'required|string',
			'description'=>'required|string'
		]);
	
		Category::whereId($categoryId)->update([
			'title'=>$request->title,
			'description'=>$request->description
		]);
	
		return response()->json([
			'message' => 'Successfully Updated!',
		], 200);
    }

	public function destroy($categoryId)
    {
        Category::whereId($categoryId)->delete();

		return response()->json(['message' => 'Deleted Successfully!']);
    }
}
