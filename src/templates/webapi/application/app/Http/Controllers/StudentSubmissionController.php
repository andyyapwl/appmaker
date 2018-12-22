<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use App\StudentSubmission;
use Carbon\Carbon;

class StudentSubmissionController extends Controller
{
	 public function getByStudentId_CategoryId($studentId,$categoryId, Request $request){
		 $result = StudentSubmission::with(['category','student','status','student.user'])
					->join('students', function($join){
						$join->on('students.id', '=', 'student_submissions.student_id');
					})
					->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					->join('submission_statuses', function($join){
						$join->on('student_submissions.status_id', '=', 'submission_statuses.id');
					})
					->join('categories', function($join){
						$join->on('student_submissions.category_id', '=', 'categories.id');
					})
					->where([['student_submissions.student_id', '=', $studentId],
						['student_submissions.category_id','=',$categoryId]])
					->get(['student_submissions.*']);	
         return response($result, 200);
    }
	
	public function getByStudentId($studentId,Request $request){
		 $result = StudentSubmission::with(['category','student','status','student.user'])
					->join('students', function($join){
						$join->on('students.id', '=', 'student_submissions.student_id');
					})
					->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					->join('submission_statuses', function($join){
						$join->on('student_submissions.status_id', '=', 'submission_statuses.id');
					})
					->join('categories', function($join){
						$join->on('student_submissions.category_id', '=', 'categories.id');
					})
					->where([['student_submissions.student_id', '=', $studentId]])
					->get(['student_submissions.*']);	
         return response($result, 200);
    }
	
	 public function show($id,Request $request){
		 $result = StudentSubmission::with(['category','student','status','student.user'])
					->join('students', function($join){
						$join->on('students.id', '=', 'student_submissions.student_id');
					})
					->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					->join('submission_statuses', function($join){
						$join->on('student_submissions.status_id', '=', 'submission_statuses.id');
					})
					->join('categories', function($join){
						$join->on('student_submissions.category_id', '=', 'categories.id');
					})
					->where('student_submissions.id', $id)
					->get(['student_submissions.*'])->first();	
         return response($result, 200);
    }
	
	 public function getBySchoolId($schoolId, Request $request){
		 $result = StudentSubmission::with(['category','student','status','student.user'])
		            ->join('students', function($join){
						$join->on('students.id', '=', 'student_submissions.student_id');
					})
					->join('users', function($join){
						$join->on('students.user_id', '=', 'users.id');
					})
					->join('submission_statuses', function($join){
						$join->on('student_submissions.status_id', '=', 'submission_statuses.id');
					})
					->join('categories', function($join){
						$join->on('student_submissions.category_id', '=', 'categories.id');
					})
					->where([['students.school_id','=',$schoolId]])
					->get(['student_submissions.*']);	
         return response($result, 200);
    }
	
	public function approve($submissionId,Request $request){

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        }
		else {
			$result = StudentSubmission::where('id',$submissionId)->first();
			$result->status_id = 2;
			$result->save();
			return response(['message' => 'Approved OK'], 200);
        }
    }
	
	public function reject($submissionId,Request $request){

        if($validator->fails()){
            return response(['message' => 'Data cannot be processed'], 422);
        }
		else {
			$result = StudentSubmission::where('id',$submissionId)->first();
			$result->status_id = 2;
			$result->save();
			return response(['message' => 'Rejected OK'], 200);
        }
    }
}
