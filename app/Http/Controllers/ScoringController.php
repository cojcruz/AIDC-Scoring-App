<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        $activeentry = DB::table('active_entry')
            ->select('*')
            ->where('id', 1)->first();
        $code = $activeentry->code;

        $userid = Auth::user()->id;
        $entrycode = null;
        $category = null;
        $judge = null;
        $score = NULL;

        switch ($userid) {
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

        $checkscore = DB::table('entries')
            ->select('*')
            ->where('code', $code)
            ->where($judge, '!=', NULL)->first();

        // Get Entry Details
        if ( $code != NULL ):
            $entry = DB::table('entries')
                ->select('*')
                ->where('code', $code)->first(); 

            // Get Category Details
            $category = $entry->category;

            switch ($userid) {
                case 2:
                    $score = $entry->judge_a;
                break;
                case 3:
                    $score = $entry->judge_b;
                break;
                case 4:
                    $score = $entry->judge_c;
                break;
            }
        endif;

        $status = !$activeentry->code ? 'standby' : 'active';

        $data = [
            'status' => $status,
            'entrycode' => $activeentry,
            'check' => $checkscore,
            'catcode' => $category,
            'score' => $score,
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
        $entryCode = $request->input('code');
        $catA = (int)$request->input('technique');
        $catB = (int)$request->input('artistry');
        $catC = (int)$request->input('musicality');
        $catD = (int)$request->input('costume');
        $score = (int)$request->input('score');
        $judge_id = (int)$request->input('judge');
        $category = $request->input('category');
        
        // Check Existing Score
        $judge = null;

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
        $checkscore = DB::table('entries')
            ->select('*')
            ->where('code', '==', $entryCode)
            ->where($judge, '!=', NULL)->first();

        if ( !$checkscore ):
            // $scores->code = $entryCode;
            // $scores->score = $score;
            // $scores->judge_id = $judge_id;
            // $scores->category = $category;
            // $scores->save();

            $judge = '';

            switch (Auth::user()->id) {
                case 2:
                    $judge = 'a';
                break;
                case 3:
                    $judge = 'b';
                break;
                case 4:
                    $judge = 'c';
                break;
            }
            // Add Score to Entries Record
            DB::table('entries')
                ->where('code', $entryCode)
                ->update([
                    'j' . strtoupper($judge) . 'catA' => $catA,
                    'j' . strtoupper($judge) . 'catB' => $catB,
                    'j' . strtoupper($judge) . 'catC' => $catC,
                    'j' . strtoupper($judge) . 'catD' => $catD,
                    'judge_' . $judge => $score,
                ]);

            $data = [
                'message' => 'Score successfully saved for Entry #' . $entryCode,
                'returnURL' => route('scoring'),
            ];

            return view('success', $data);
        else:

            $data = [
                'message' => 'Score for Entry #' . $entryCode . ' already exist.',
                'returnURL' => route('scoring'),
            ];

            return view('error', $data);
        endif;
    }

    public function checkScores(Request $request) {
        $activeEntry = DB::table('entries')
            ->select('*')
            ->where('code', $request->input('code'))->first();        
        $scoresEntered = isset($activeEntry->judge_a) && isset($activeEntry->judge_b) && isset($activeEntry->judge_c) ? true : false;

        if ($scoresEntered) {
            return Response::json([ 
                'success' => true
            ], 200);
        } else {
            return Response::json([
                'success' => false
            ], 400);
        }
    }
}
