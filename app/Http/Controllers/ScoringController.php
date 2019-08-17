<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Scores;
use App\Entries;
use Log;
use Auth;

class ScoringController extends Controller
{
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
        //Check for active entry
        $entry = DB::table('active_entry')
            ->select('*')
            ->where('id', 1)->first();
        $code = $entry->code;

        $userid = Auth::user()->id;
        $check = DB::table('scores')
            ->select('*')
            ->where('code', $code)
            ->where('judge_id', $userid)->first();        
        $entry = '';
        $category = '';
        // Get Entry Details
        if ( $code != NULL ):
            $entry = DB::table('entries')
                ->select('*')
                ->where('code', $code)->first();                
            // Get Category Details
            $category = DB::table('categories')
                ->select('*')
                ->where('code', $entry->category)->first();
        endif;
        
        $status = $entry != NULL ? 'active' : 'standby';

        $data = [
            'status' => $status,
            'entrycode' => $entry,
            'check' => $check,
            'category' => $category,
        ];

        return view('scoring', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function saveScore(Request $request)
    {
        // Setup Vars
        $code = $request->input('code');
        $score = $request->input('score');
        $judge = $request->input('judge');
        $category = $request->input('category');
        $scores = new Scores();

        // Check Existing Score
        $check = DB::select('select * from scores where code = '. $code . ' and judge_id = ' . $judge );

        if ( !$check ):
            $scores->code = $code;
            $scores->score = $score;
            $scores->judge_id = $judge;
            $scores->category = $category;
            $scores->save();

            $judge = '';

            switch (Auth::user()->id) {
                case 2:
                    $judge = 'judge_a';
                break;
                case 3:
                    $judge = 'judge_b';
                break;
                case 4:
                    $judge = 'judge_c';
                break;
            }
            // Add Score to Entries Record
            DB::table('entries')
                ->where('code', $code)
                ->update([$judge => $score]);

            $data = [
                'message' => 'Score successfully saved for Entry #' . $code,
                'returnURL' => route('scoring'),
            ];

            return view('success', $data);
        else:

            $data = [
                'message' => 'Score for Entry #' . $code . ' already exist.',
                'returnURL' => route('scoring'),
            ];

            return view('error', $data);
        endif;
    }
}
