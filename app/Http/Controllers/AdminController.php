<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    public function login(Request $request)
	{
		$request->validate([
    	    'email' => 'required|email',
    	    'password' => 'required'
    	]);
		
    	$user = Admin::where('email', $request->email)->first();
    	if (! $user || ! Hash::check($request->password, $user->password)) {
    	    return response()->json(['message' => 'Invalid email or password'], 401);
    	}
	
    	if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
			$user = Auth::guard('admin')->user();
			$token = $user->createToken('MyApp', ['admin'])->plainTextToken;
			return response()->json([
				'message' => 'Admin Successfully Authenticated!',
				'token' => $token,
				'redirect' => '/admin/dashboard'
			]);
		}
	}

	public function logout(Request $request)
	{
    	if($request->user()){
    	    $request->user()->currentAccessToken()->delete();
    	    return response()->json([
    	        'message' => 'Admin Successfully Logged out!'
    	    ]);
    	}
    	return response()->json(['error' => 'Unauthenticated'], 401);
	}
}
