<?php

namespace App\Http\Controllers\Api;

use App\EventFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventFileController extends Controller
{
    public function index()
    {
        return EventFile::all();
    }

    public function store(Request $request)
    {
		$file = $request->file('file');
        $eventFile = EventFile::create($request->all());

		return response($file->length, 200);
        //return $eventFile;
    }

    public function show($id)
    {
        return EventFile::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $eventFile = EventFile::findOrFail($id);
        $eventFile->update($request->all());

        return $eventFile;
    }

    public function destroy($id)
    {
        $eventFile = EventFile::findOrFail($id);
        $eventFile->delete();

        return '';
    }
}
