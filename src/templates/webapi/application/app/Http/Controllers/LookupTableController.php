<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LookupTableController extends Controller
{
    public function index($tableCode, Request $request)
    {
        $rows = DB::table($tableCode)->get();
		return response($rows, 200);
    }
	
	public function show($tableCode,$id, Request $request)
    {
        $rows = DB::table($tableCode)->where('id',$id)->get();
		return response($rows, 200);
    }
}
