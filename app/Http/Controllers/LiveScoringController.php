<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

class LiveScoringController extends Controller
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
    public function index()
    {
        // Get Active Entry
        $activecode = DB::table('active_entry')
            ->select('*')
            ->where('id', '1')->first();
        $code = $activecode->code;
        $entry = '';
        $category = '';
        $judge_a = '';
        $judge_b = '';
        $judge_c = '';

        // Get Entry Details
        if ( $code != NULL ):

            $entry = DB::table('entries')
                ->select('*')
                ->where('code', $code)->first();

            // Get Category Details
            $category = DB::table('categories')
                ->select('*')
                ->where('code', $entry->category)->first();

            // Get Judge's Scores
            $entry = DB::table('entries')
                ->select('*')
                ->where('code', $code)->first();
            
            $judge_a = $entry->judge_a;
            $judge_b = $entry->judge_b;
            $judge_c = $entry->judge_c;

        endif;
        
        // Set Live Page Layout
        $layout = $code ? 'active' : 'standby';

        // Check if all judges has submitted their scores for the current active entry.
        if ( $layout == 'active' && $judge_a != NULL && $judge_b != NULL && $judge_c != NULL ) {
            $layout = 'showscores';
        }

        $data = [
            'category' => $category,
            'layout' => $layout,
            'code' => $code,
            'entry' => $entry,
            'category' => $category,
            'judge_a' => $judge_a,
            'judge_b' => $judge_b,
            'judge_c' => $judge_c,
        ];

        return view('livescoring', $data);
    }
}
