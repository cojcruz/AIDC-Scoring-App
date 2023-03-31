<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class CategoriesController extends Controller
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
            ->select('*')->orderBy('id')->get();

        $data = [
            'categories' => $categories,
        ];

        return view('categories', $data);
    }

    public function edit(string $id) {

        $category = DB::table('categories')
            ->select('*')
            ->where('id', $id)->first();

        $data = [
            'category' => $category,
        ];

        return view('editCat', $data);
    }

    public function add(Request $request){

        $name = $request->input('category');
        $code = $request->input('code');
        $status = '';

        try {
            DB::table('categories')->insert([
                'name' => $name,
                'code' => $code
            ]);

            $status = "Category Added!";
        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage() . '\n');

            $status = "Failed to add new category.";
        }
        
        return redirect()->route('categories')->with('status', $status);
    }

    public function save(Request $request) {

        $id = $request->input('id');
        $code = $request->input('categoryCode');
        $label = $request->input('categoryLabel');
        $status = '';

        $currentEntry = DB::table('categories')
            ->select('*')
            ->where('id', $id)->first();

        if ( $code != $currentEntry->code || $label != $currentEntry->name ) {

            try {
                DB::table('categories')
                ->where('id',$id)
                ->update(['code'=>$code, 'name'=>$label]);
            } catch (Exception $e ) {
                echo $e->getMessage();
            }

            $status = 'Save successful!';
        } else {

            $status = 'No changes were made.';

        }

        return redirect()->route('categories')->with('status', $status);
    }

    public function confirmDelete(string $id) {

        $category = DB::table('categories')
                        ->select('*')
                        ->where('id', $id)->first();

        $data = [
            'category' => $category,
        ];

        return view('deleteCat', $data );
    }

    public function delete(Request $request) {

        $categories = DB::table('categories')
                        ->select('*')->orderBy('id')->get();                        
        $status = '';

        try {
            DB::table('categories')
                ->where('id', $request->input('id'))
                ->delete();

            $status = 'Category successfully deleted!';

        } catch (Exception $e) {
            Log::ERROR('Caught Error: ' . $e->getMessage(), '\n' );

            $status = 'Error: ' . $e->getMessage();
        }

        return redirect()->route('categories')->with('status', $status);
    }

}
