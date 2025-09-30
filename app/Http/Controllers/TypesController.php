<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('types.index', compact('types','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // if a user click 'submit' without giving a status name, dont collapse the page 
        // and if a user give a status name that is not 'unique', dont store it
        
        $request->validate([
            'name' => 'required|max:50|unique:types,name',
            'status_id' => 'required|in:3,4'
        ]);
           
        $user = Auth::user();
        $user_id = $user->id;

        $type = new Type();
        $type->name = $request['name'];
        $type->slug = Str::slug($request['name']);
        $type->status_id = $request['status_id'];
        $type->user_id = $user_id;
        $type->save();

        session()->flash("success","New Type Form Is Created Successfully");
        return redirect(route('types.index'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $type = Type::findOrFail($id);
        $type->name = $request['name'];
        $type->slug = Str::slug($request['name']);
        $type->user_id = $user_id;

        $type->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('types.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // no need to $type = new Type(); cuz you've already given that in store method
        $type = Type::findOrFail($id);
        $type->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}


// php artisan make:controller TypesController -r
