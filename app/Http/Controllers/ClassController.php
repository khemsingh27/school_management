<?php

namespace App\Http\Controllers;
use App\Models\Classes;

use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    //View Classes
    public function viewClass(Request $request){
        $class = Classes::all();
// dd($class);
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $class->count(),
            'recordsFiltered' => $class->count(),
            'data' => $class,
        ]);
    }
    // Add Classes
    public function addClass(Request $request){
        $request->validate([
            'name' => ['required'],
        ]);
        $class = Classes::create([
            'name' => $request->name,
        ]);
    }
    // Edit Classes
    public function editClass(Request $request){
        $id = $request->id;
        $name = $request->name;
        $class = Classes::find($id);
 
        $class->name = $name;
 
        $class->save();
    }
    // Delete Classes
    public function deleteClass(Request $request){

        $id = $request->id;
        $user = Classes::find($id);

        $user->delete();
    }
            // New View Classes
            public function newView(){
                $main = "Hello";
                $classes = view('auth.addClasses')->render();
                return response()->json([
                    'status' => true,
                    'main' => $classes,
                ]);
            }
}
