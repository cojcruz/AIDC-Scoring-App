<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entries;
use Log;

class EntriesController extends Controller
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
    public function index(Request $request)
    {
        $entries = DB::table('entries')
            ->select('*')
            ->orderBy('id')->get();
        $activeEntry = DB::table('active_entry')->first();
        $schools = DB::table('schools')
            ->select('*')
            ->orderBy('id')->get();
        $categories = DB::table('categories')
            ->select('*')
            ->orderBy('id')->get();

        $data = [
            'entries' => $entries,
            'activeEntry' => $activeEntry,
            'schools' => $schools,
            'categories' => $categories,
        ];

        //Log:info($data);

        return view('entries', $data);
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
        $code = $request->input('entryCode');
        $name = $request->input('entryName');
        $school = $request->input('entrySchool');
        $category = $request->input('entryCategory');
        $status = '';

        $currentEntry = DB::table('entries')
            ->select('*')
            ->where('id', $id)->first();

        try {
            DB::table('entries')
            ->where('id',$id)
            ->update([
                'code'=>$code, 
                'entry_school'=>$school,
                'entry_name'=>$name,
                'category'=>$category,
            ]);
        } catch (Exception $e ) {

            return redirect()->route('entries')->with('status', $e->getMessage());
        }

        return redirect()->route('entries')->with('status', $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $code = $request->input('entryCode');
        $name = $request->input('entryName');
        $school = $request->input('entrySchool');
        $category = $request->input('categoryCode');
        $status = '';

        try {
            DB::table('entries')->insert([
                'code' => $code,
                'entry_school' => $school,
                'entry_name' => $name, 
                'category' => $category
            ]);

            $status = "Entry Added!";
        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage() . '\n');

            $status = "Failed to add new entry.";
        }

        return redirect()->route('entries')->with('status', $status);
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
        $entry = DB::table('entries')
            ->select('*')
            ->where('id', $id)->first();

        $data = [
            'entry' => $entry,
        ];

        return view('editEntry', $data);
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

    public function confirmDelete(string $id) {

        $entry = DB::table('entries')
                        ->select('*')
                        ->where('id', $id)->first();

        $data = [
            'entry' => $entry,
        ];

        return view('deleteEntry', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $entries = DB::table('entries')
                        ->select('*')->orderBy('id')->get();                        
        $status = '';

        try {
            DB::table('entries')
                ->where('id', $request->input('id'))
                ->delete();

            $status = 'Entry successfully deleted!';

        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage(), '\n' );

            $status = 'Error: ' . $e->getMessage();
        }

        return redirect()->route('entries')->with('status', $status);
    }
}
