<?php

namespace App\Http\Controllers;

use App\Models\Genders;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genders = Genders::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('genders.index', compact('genders','statuses'));
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

        $request->validate([
            'name' => 'required|max:50|unique:genders,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $gender = new Genders();
        $gender->name = $request['name'];
        $gender->slug = Str::slug($request['slug']);
        $gender->status_id = $request['status_id'];
        $gender->user_id = $user_id;
        $gender->save();

        session()->flash("success","New Gender Form Is Created Successfully");
        return redirect(route('genders.index'));
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

        $gender = Genders::findOrFail($id);
        $gender->name = $request['name'];
        $gender->slug = Str::slug($request['slug']);
        $gender->user_id = $user_id;

        $gender->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('genders.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gender = Genders::findOrFail($id);

        $gender->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}
