<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Activity;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followUnfollowData(User $user, Request $request, $fetchOnly = false)
    {
        if(!$fetchOnly){
            $follow = $request->follow;
            if ($follow !== null) {
                if ($follow) {
                    if (auth()->user()->followings->contains($user->id)) {
                        return response()->json(['error' => 'You already followed this user'], 200);
                    }
                
                    auth()->user()->followings()->attach($user->id);
                    $message = "You followed {$user->name}";
                } else {
                    if (!auth()->user()->followings->contains($user->id)) {
                        return response()->json(['error' => 'You already unfollowed this user'], 200);
                    }
                
                    auth()->user()->followings()->detach($user->id);
                    $message = "You unfollowed {$user->name}";
                }
            
                Activity::create([
                    "user_id" => auth()->user()->id,
                    "description" => $message,
                    "activitiable_id" => $user->id,
                    "activitiable_type" => "App\Models\Follow"
                ]);
            }
            $followings = auth()->user()->followings;
            $followers = auth()->user()->followers;
            $followed = auth()->user()->followings()->where('following_id', $user->id)->first() !== null;
            
            $followings = $followings->map(function ($following) {
                return [
                    'id' => $following->id,
                    'name' => $following->name
                ];
            });
            
            $followers = $followers->map(function ($follower) {
                return [
                    'id' => $follower->id,
                    'name' => $follower->name
                ];
            });

            return response()->json([
                'message' => isset($message) ? $message : "Fetching data from id:". auth()->user()->id . " - " . auth()->user()->name,
                'followed' => $followed,
                'followingsCount' => $followings->count(),
                'followersCount' => $followers->count(),
                'whoFollowedYou' => $followers,
                'youFollowed' => $followings,
                'followersCountById' => $user->followers->count(),
                'followingsCountById' => $user->followings->count()
            ]);
        }
    }
}
