<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use FFMpeg;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->back()->with('success','File Uploaded Successfully!');
    }

    public function uploadFile(Request $request) {
        $file = $request->file;
        $entry = $request->input('entryCode');
        $cat = $request->input('catCode');
        $date = date('Y-m-d-H.i.s');
        $judge = '';

        switch ($request->input('judge')) {
            case 2:
                $judge = "a";
            break;
            case 3:
                $judge = "b";
            break;
            case 4:
                $judge = "c";
            break;
        }

        $filename = $entry . '_' . $cat . '_' . 'judge' . '-' . $judge . '_' . $date . '.wav';
        $fname = $entry . '_' . $cat . '_' . 'judge' . '-' . $judge . '_' . $date . '.mp3';

        $file->move(public_path('storage'), $filename);

        try {
            FFMpeg::fromDisk('audio')
                ->open('/storage/' . $filename)
                ->export()
                ->toDisk('audio')
                ->inFormat(new FFMpeg\Format\Audio\Mp3)
                ->save('/storage/converted/' .  $fname);

            Log:info(public_path('storage') . '/' . $filename);
            return back()->with('success', 'File uploaded')->with('file', $fname);  
        } catch (EncodingException $exception) {
            $command = $exception->getCommand();
            $errorLog = $exception->getErrorOutput();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
