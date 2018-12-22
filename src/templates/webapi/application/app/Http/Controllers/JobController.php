<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Job;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;

class JobController extends Controller
{
	use LogsActivity;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $job = Job::latest()->paginate(25);

        return $job;
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
        $job = Job::create(array_merge($request->all(), ['created_at' => date('Y-m-d H:i:s'),
														'updated_at' => date('Y-m-d H:i:s'),
														'is_active' => 1]));	

		$title = $request->get('title');
		$description = $request->get('description');
			
		fcm()
		->data(
			[
				'id' => $job->id
			]
		) 
		->toTopic('all') 
		->notification([
			'title' => $title,
			'body' => $description,
			'sound' => 'default',
			'click_action' => 'FCM_PLUGIN_ACTIVITY',
			'icon' => 'fcm_push_icon',
		])
		->send();
		
        return response()->json($job, 201);
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
        $job = Job::findOrFail($id);

        return $job;
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
        
        $job = Job::findOrFail($id);
        $job->update($request->all());

        return response()->json($job, 200);
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
        Job::destroy($id);

        return response()->json(null, 204);
    }
}
