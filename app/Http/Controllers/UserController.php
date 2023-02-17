<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
	public function index(){
		return User::all();
	}
    public function register(Request $request)
	{
		$request->validate([
			'name' => 'required|string',
    		'email' => 'required|string|email|unique:users',
    		'password' => 'required|string|confirmed',
			'profile_picture' => 'string'
		]);

		$user = User::create([
			'name'=>$request->name,
			'email'=>$request->email,
			'password'=>Hash::make($request->password),
			'profile_picture'=>$validatedData['profile_picture'] ?? $request->profile_picture
		]);

		return response()->json([
			'message'=>'User Successfully Created!',
			'user' => $user,
		]);
	}

	public function login(Request $request)
	{
		$request->validate([
    	    'email' => 'required|email',
    	    'password' => 'required'
    	]);

    	$user = User::where('email', $request->email)->first();
    	if (! $user || ! Hash::check($request->password, $user->password)) {
    	    return response()->json(['message' => 'Invalid email or password'], 401);
    	}

    	if(Auth::guard('user')->attempt(['email' => $request->email, 'password' => 	$request->password])){
			$user = Auth::guard('user')->user();
			$token = $user->createToken('MyApp', ['user'])->plainTextToken;
			return response()->json([
				'message' => 'User Successfully Authenticated!',
				'token' => $token,
				'redirect' => '/dashboard'
			]);
		}
	}

	public function logout(Request $request)
	{
    	if($request->user()){
    	    $request->user()->currentAccessToken()->delete();
    	    return response()->json([
    	        'message' => 'User Successfully Logged out!'	
    	    ]);
    	}
    	return response()->json(['error' => 'Unauthenticated'], 401);
	}

	public function userDetails()
	{
		return response()->json(['data' => Auth::user()]);
	}

	public function userDetailsAdmin($user_id)
	{
		$user = User::find($user_id);
		return response()->json(['data' => $user]);
	}

	public function visitUser($user_id)
	{
		$user = User::find($user_id);

		return ($user)
			?response()->json(['data' => $user])
			:response()->json(['error' => 'User not found'], 404);
	}


	public function updateEmail(Request $request, $user_id)
	{
		$validatedData = $request->validate([
			'email' => 'required|string|email|unique:users',
		]);
	
		$user = User::findOrFail($user_id);
		$user->email = $validatedData['email'];
		$user->save();
	
		return response()->json(['message' => 'Email Updated Successfully.'], 200);
	}

	public function updateAvatar(Request $request, $user_id)
	{
		$validatedData = $request->validate([
			'profile_picture' => 'string'
		]);
	
		$user = User::findOrFail($user_id);
		$user->profile_picture = $validatedData['profile_picture'];
		$user->save();

		return response()->json(['message' => 'Profile Picture Updated Successfully.'], 200);
	}

	public function updatePassword(Request $request, $user_id)
	{
		$validatedData = $request->validate([
			'password' => 'required|string',
		]);
	
		$user = User::findOrFail($user_id);
		$user->password = Hash::make($validatedData['password']);
		$user->save();

		return response()->json(['message' => 'Password Updated Successfully.'], 200);
	}

	public function updateDetails(Request $request, $user_id)
	{
		$validatedData = $request->validate([
			'name' => 'required|string',
		]);
	
		$user = User::findOrFail($user_id);
		$user->name = $validatedData['name'];
		$user->save();
	
		return response()->json(['message' => 'User Details Updated Successfully.'], 200);
	}

	public function destroy($user_id)
    {
        User::whereId($user_id)->delete();

		return response()->json(['message' => 'Deleted Successfully!']);
    }
}
