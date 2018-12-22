<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers;
use App\User;
use App\UserProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProfileController extends Controller
{
	/*
	public function getCurrent(Request $request){
		$user = $request->user;
		$userId = $user->id;
		
		$profile = UserProfile::where('user_id',$userId)->first();
        if($profile){
			return response(['username'=>$user->username,'mobile'=>$profile->mobile], 200);
        } 
		else {
            return response('not found: ' . $userId, 404);
        }
    }
	*/
	
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        }
		else {
			$username = $request->get('username');
			$mobile = $request->get('mobile');
			$user = $request->user;
			
			$user->username = $username;
			$user->save();
			
			$userId = $user->id;
			$userProfile = UserProfile::where('user_id',$userId)->first();
			$userProfile->mobile = $mobile;
			$userProfile->save();
			return response(['message' => 'Update OK'], 200);
        }
    }
}
