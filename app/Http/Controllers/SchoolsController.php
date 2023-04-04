<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class SchoolsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = DB::table('schools')
            ->select('*')
            ->orderBy('id')->get();

        $data = [
            'schools' => $schools,
        ];

        return view('schools', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $status = '';

        try {
            DB::table('schools')->insert([
                'school_name' => $request->input('name'),
                'created_at' => Carbon::now()
            ]);

            $status = "Entry Added!";
        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage() . '\n');

            $status = "Failed to add new entry.";
        }

        return redirect()->route('schools')->with('status', $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $status = '';

        try {
            DB::table('schools')
            ->where('id',$id)
            ->update([
                'school_name' => $name, 
                'updated_at' => Carbon::now()
            ]);
        } catch (Exception $e ) {

            return redirect()->route('schools')->with('status', $e->getMessage());
        }

        return redirect()->route('schools')->with('status', $status);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $school = DB::table('schools')
            ->select('*')
            ->where('id', $id)->first();

        $data = [
            'school' => $school,
        ];

        return view('editSchool', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {                       
        $status = '';

        try {
            DB::table('schools')
                ->where('id', $request->input('id'))
                ->delete();

            $status = 'Entry successfully deleted!';

        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage(), '\n' );

            $status = 'Error: ' . $e->getMessage();
        }

        return redirect()->route('schools')->with('status', $status);
    }

    public function confirmDelete(string $id) 
    {
        $school = DB::table('schools')
                        ->select('*')
                        ->where('id', $id)->first();

        $data = [
            'school' => $school,
        ];

        return view('deleteSchool', $data );
    }
}
