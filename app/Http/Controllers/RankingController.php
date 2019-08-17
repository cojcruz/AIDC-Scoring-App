<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

class RankingController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $categories = DB::table('categories')
            ->select('*')->get();

        $data = [
            'layout' => 'form',
            'categories' => $categories,
            'cat' => $request->input('category'),
        ];

        return view('ranking', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {
        $entries = DB::table('entries')
            ->select('*')
            ->where('category', '=', $request->input('category'))
            ->whereNotNull('judge_a')
            ->whereNotNull('judge_b')
            ->whereNotNull('judge_c')->get();

        if ( $request->input('category') == 'All'):
            $entries = DB::table('entries')
                ->select('*')->get();
        endif;

        $categories = DB::table('categories')
            ->select('*')->get();

        $data = [
            'categories' => $categories,
            'cat' => $request->input('category'),
            'layout' => 'results',
            'entries' => $entries,
        ];


        return view('ranking', $data);
    }
}
