<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

class ProfilePicController extends Controller
{
	 public function show($sessionId, $id, Request $request){
		$client = new Client();
		$res = $client->request('GET', env('SERVER_URL', '') . '/vol_photo?volId=' . $id, 
				[
				'headers' => [
					'pid' => env('PID', ''),
					'aid' => env('AID', ''),
					'sessionId' => $sessionId
				]
		]);
		$statusCode = $res->getStatusCode();
        $body = (string)$res->getBody();
        return response($body, $statusCode);
    }
	
	public function upload(Request $request){
		$file = $request->file('file');
		$sessionId = $request->input('session_id');
		$vol_id = $request->input('vol_id');
		$client = new Client();
		
		$res = $client->request('POST', env('SERVER_URL', '') . '/vol_photo_upload', 
			[
				'headers' => [
					'pid' => env('PID', ''),
					'aid' => env('AID', ''),
					'sessionId' => $sessionId
				],
				'multipart' => [
				   [
					'name'     => 'file',
					'contents' => file_get_contents($file),
					'filename' => $file->getFilename()
				   ],
				    [
					'name'     => 'vol_id',
					'contents' => $vol_id
				   ]
				]
			]
		);
		$statusCode = $res->getStatusCode();
        $body = (string)$res->getBody();
        return response($body, $statusCode);
		
		
		//$file = $request->file('file');
		//$sessionId = $request->get('session_id');
		//$vol_id = $request->get('vol_id');
		
		//$statusCode = 200;
		//var_dump($request->all());
        //$body = 'ccc:' . $vol_id;
        //return response($body, $statusCode);
    }
	
	public function testAdd(Request $request){
        return response(["status"=>0, "data"=>["vol_id"=>"f6af524f-d475-411d-9b98-4c4346baad28"]], 200);
    }
}
