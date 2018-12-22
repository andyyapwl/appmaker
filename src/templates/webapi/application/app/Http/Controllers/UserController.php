<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use App\User;
use App\UserProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function approve($userId,Request $request){

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        }
		else {
			
			$user->status_id = 2;
			$user->save();
			return response(['message' => 'Approved OK'], 200);
        }
    }
	
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        } else {
			$username = $request->get('username');
			$email = $request->get('email');
			$password = $request->get('password');
			$mobile = $request->get('mobile');
			
			$checkExist = User::where('email',$email)->first();
			
            if($checkExist){
                return response(['message' => 'Duplicate email'], 400);
            } else {
                $user = new User();
				$user->username = $username;
				$user->name = $username;
				$user->email = $email;
				$user->password = $password;
				$user->role = 'member';
                $user->save();
				
				$userProfile = new UserProfile();
				$userProfile->mobile = $mobile;
				$userProfile->user_id = $user->id;
				$userProfile->save();
				
				
                return response(['message' => 'Registration success'], 200);
            }
        }
    }
}
