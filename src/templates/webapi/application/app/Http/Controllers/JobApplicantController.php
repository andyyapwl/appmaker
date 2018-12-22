<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\JobApplicant;
use Illuminate\Http\Request;

class JobApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $job_applicants = JobApplicant::latest()->paginate(25);

        return $job_applicants;
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
        
        $job_applicant = JobApplicant::create($request->all());

        return response()->json($job_applicant, 201);
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
        $job_applicant = JobApplicant::findOrFail($id);

        return $job_applicant;
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
        
        $job_applicant = JobApplicant::findOrFail($id);
        $job_applicant->update($request->all());

        return response()->json($job_applicant, 200);
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
        JobApplicant::destroy($id);

        return response()->json(null, 204);
    }

	 public function getApplicantsByCompanyId($id, Request $request){
		 $applicants = JobApplicant::with(['student','job','student.user'])
					 ->join('students', function($join){
						$join->on('students.id', '=', 'job_applicants.student_id');
					})
					 ->join('jobs', function($join){
						$join->on('job_applicants.job_id', '=', 'jobs.id');
					})
					 ->join('users', function($join){
						$join->on('users.id', '=', 'students.user_id');
					})
					->where('job_applicants.job_id', '=', $id)
					->get(['job_applicants.*']);	
         return response($applicants, 200);
    }
}
