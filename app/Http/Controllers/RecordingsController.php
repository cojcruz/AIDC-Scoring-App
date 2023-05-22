<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index() {
        $dir = public_path() . '/storage/converted';

        $files = preg_grep('~\.(mp3)$~', scandir($dir));;

        $data = [
            'files' => $files,
            'path' => "/storage/converted",
        ];

        return view('recordings', $data);
    }
}
