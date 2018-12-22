<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

class AttachmentController extends Controller
{
	 public function show($sessionId, $id, Request $request){
		$client = new Client();
		$res = $client->request('GET', env('SERVER_URL', '') . '/get_program_submission_attachment/' . $id, 
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
}
