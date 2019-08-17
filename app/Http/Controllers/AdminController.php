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
		$data = DB::table('active_entry')->select('code')->where('id', 1)->get(array('code'))->toArray();
		
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
		$data = DB::update('update active_entry set code = :code where id = 1', ['code' => $request->input('code')]);
		Log::info( $data );

        return $data == 1 ? "success" : "fail";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activateCategory(Request $request)
    {
        $data = DB::update('update active_category set code = :code where id = 1', ['code' => $request->input('code')]);
        Log::info( $data );

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

    
}
