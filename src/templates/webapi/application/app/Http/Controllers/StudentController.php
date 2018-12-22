<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, DB, Hash, Mail;
use App\Controllers;
use App\User;
use App\UserProfile;
use App\UserRole;
use App\Student;
use Carbon\Carbon;
use App\Role;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
		 $students = Student::with(['nationality','race','user','user.status','school'])
					 ->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					 ->join('account_statuses', function($join){
						$join->on('users.status_id', '=', 'account_statuses.id');
					})
					->get(['students.*']);
         return $students;
		 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
			 'dob' => 'required',
			 'gender' => 'required',
			 'identificationNo' => 'required',
			 'race_id' => 'required',
			 'nationality_id' => 'required',
			 'first_name' => 'required',
			 'last_name' => 'required',
			 'preferred_contact_number' => 'required',
			 'class_name' => 'required',
			 'name' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        } else {
			
			$username = $request->get('username');
			$email = $request->get('email');
			$password = $request->get('password');
			$dob = $request->get('dob');
			$gender = $request->get('gender');
			$identificationNo = $request->get('identificationNo');
			$race_id = $request->get('race_id');
			$phone = $request->get('phone');
			$nationality_id = $request->get('nationality_id');
			$class_name = $request->get('class_name');
			$first_name = $request->get('first_name');
			$last_name = $request->get('last_name');
			
			$name = $request->get('name');
			$preferred_contact_number = $request->get('preferred_contact_number');
			$checkExist = User::where('email',$email)->first();
			
            if($checkExist){
                return response(['message' => 'Duplicate email'], 400);
            } else {
				
                $user = new User();
				$user->username = $username;
				$user->name = $username;
				$user->email = $email;
				$user->first_name = $first_name;
				$user->last_name = $last_name;
				$user->name = $first_name . ' ' . $last_name;
				$user->password = Hash::make($password);
				$user->is_admin = 0;
				$user->status_id = 1;
				$user->is_active = 1;
                $user->save();
				
				$studentRole = Role::where('title','=','Student')->first();
				$userRole = new UserRole();
				$userRole->user_id = $user->id;
				$userRole->role_id = $studentRole->id;
				$userRole->is_active = 1;
				$userRole->title = "Untitled";
				$userRole->save();
					
				$student = new Student();
				$student->title = $name;
				$student->user_id = $user->id;
				$student->dob = $dob;
				$student->gender = $gender;
				$student->identificationNo = $identificationNo;
				$student->race_id = $race_id;
				$student->nationality_id = $nationality_id;
				$student->user_id = $user->id;
				$student->preferred_contact_number = $preferred_contact_number;
				$student->is_active = 1;
				$student->class_name = $class_name;
				$student->save();
				
                return response()->json($student, 201);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $student = Student::findOrFail($id);
        $student->update($request->all());

        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::destroy($id);

        return response()->json(null, 204);
    }
	
	
	
	 public function getBySchool($id, Request $request){
		 $students = Student::with(['nationality','race','user','user.Status','school'])
					 ->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					 ->join('account_statuses', function($join){
						$join->on('users.status_id', '=', 'account_statuses.id');
					})
					->where('students.school_id', '=', $id)
					->get(['students.*']);	
         return response($students, 200);
    }
	
	public function getById($id, Request $request){
		 $students = Student::with(['nationality','race','user','user.Status','school'])
					 ->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					 ->join('account_statuses', function($join){
						$join->on('users.status_id', '=', 'account_statuses.id');
					})
					->where('students.id', '=', $id)
					->get(['students.*'])->first();
         return response($students, 200);
    }
	
	
}
