<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use App\User;
use App\UserRole;
use App\Teacher;
use Carbon\Carbon;
use App\Role;

class TeacherController extends Controller
{
	 public function getByUserId($id, Request $request){
		 $items = Teacher::with(['User','School'])
					 ->join('users', function($join){
						$join->on('teachers.user_id', '=', 'users.id');
					})
					 ->join('schools', function($join){
						$join->on('teachers.school_id', '=', 'schools.id');
					})
					->where('Teachers.user_id', '=', $id)
					->get(['Teachers.*'])->first();	
         return response($items, 200);
    }
	
}
