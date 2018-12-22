<?php

namespace App\Http\Controllers;
use Validator, DB, Hash, Mail;
use Illuminate\Http\Request;
use App\Controllers;
use App\SubmissionFile;
use Carbon\Carbon;

class SubmissionFileController extends Controller
{
	 public function getBySubmissionId($submissionId, Request $request){
		 $result = SubmissionFile::where('submission_id', $submissionId)
					->get();	

		 for($i=0;$i<count($result);$i++) {
			 $item = $result[$i];
			 $content = base64_encode(file_get_contents($item->url));
			 $item->setFileContentAttribute($content);
		 }
		
         return response($result, 200);
    }
	
	 public function show($id, Request $request){
		 $item = SubmissionFile::where('id', $id)
					->get()->first();
		 $content = base64_encode(file_get_contents($item->url));
		 $item->setFileContentAttribute($content);
	
         return response($item, 200);
    }
}
