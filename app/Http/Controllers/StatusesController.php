<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::all();
        return view('statuses.index', compact('statuses'));
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
            'name' => 'required|unique:statuses,name'
        ],[
            'name.required' => 'Please enter a status name.',
            'name.unique'   => 'This status already exists.'
        ]);

            //  user that is already authenticated
        $user = Auth::user();
        // dd(Auth::check(), Auth::user());

        $user_id = $user->id;

        $status = new Status();
        // $request['name'] is same as POST[] that we use in php
        $status->name = $request['name'];
                        // slug the name 
        $status->slug = Str::slug($request['name']);
        //   from above.  $user_id = $user->id;
        $status->user_id = $user_id;

        $status->save();

        session()->flash("success","New Status Form Is Created Successfully");
        return redirect(route('statuses.index'));
        
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

        $status = Status::findOrFail($id);
        $status->name = $request['name'];
        $status->slug = Str::slug($request['name']);
        $status->user_id = $user_id;

        $status->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // no need to $status = new Status(); cuz you've already given that in store method
        $status = Status::findOrFail($id);
        $status->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}


// php artisan make:controller StatusesControll
// er -r