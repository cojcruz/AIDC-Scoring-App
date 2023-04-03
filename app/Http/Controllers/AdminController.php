<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;


class AdminController extends Controller
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
        $categories = DB::table('categories')
            ->select('*')->get();

        $data = [
            'categories' => $categories,
        ];

        return view('admin', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function findEntry(Request $request)
    {
    	$data = DB::select('select * from entries where code = :code', ['code' => $request->input('code')] );

        return $data != NULL ? json_encode($data) : 'Not found';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getActive()
    {
		$data = DB::table('active_entry')
            ->select('code')
            ->where('id', 1)->get(array('code'))->toArray();
		
		$data = json_encode($data);

		return $data;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activateEntry(Request $request)
    {
        DB::table('active_entry')
            ->update(['code' => $request->input('code')])
            ->where('id', 1 );

        $entry = DB::table('entries')
            ->where('code',$request->input('code'))->first();

        DB::table('active_category')
            ->update(['code' => $entry->category])
            ->where('id',1);
        
        return redirect()->back()->with('status', "Entry " . $request->input('code') . ' Activated!');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setEntry(string $id)
    {
        // Set active entry in active_entry table
        DB::table('active_entry')
            ->where('id', '1')
            ->update(['code' => $id]);

        $entry = DB::table('entries')
            ->select('*')
            ->where('code', $id)->first();

        DB::table('active_category')
            ->where('id', '1')
            ->update(['code' => $entry->category]);

        return redirect()->back()->with('status', "Entry " . $id . ' Activated!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activateCategory(Request $request)
    {
        DB::update('update active_category set code = :code where id = 1', ['code' => $request->input('code')]);

        return $data == 1 ? "success" : "fail";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearEntry(Request $request)
    {
		$data = DB::update('update active_entry set code = :code where id = 1', ['code' => NULL]);
		Log::info( $data );

        return $data == 1 ? "success" : "fail";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deactivateEntry(string $id)
    {
        // Remove existing active entry in active_entry table
        DB::table('active_entry')
            ->where('id', '1')
            ->update(['code' => NULL]);

        DB::table('active_category')
            ->where('id', '1')
            ->update(['code' => NULL]);

        return redirect()->back()->with('status', 'Entry #' . $id . ' Deactivated.');
    }

    
}
