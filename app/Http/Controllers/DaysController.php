<?php

namespace App\Http\Controllers;

use App\Models\Days;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $days = Days::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('days.index', compact('days','statuses'));
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
            'name' => 'required|max:50|unique:days,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $day = new Days();
        $day->name = $request['name'];
        $day->slug = Str::slug($request['slug']);
        $day->status_id = $request['status_id'];
        $day->user_id = $user_id;
        $day->save();

        session()->flash("success","New Day Form Is Created Successfully");
        return redirect(route('days.index'));
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

        $day = Days::findOrFail($id);
        $day->name = $request['name'];
        $day->slug = Str::slug($request['slug']);
        $day->user_id = $user_id;

        $day->save();

         session()->flash("success","Updated Successfully");
        return redirect(route('days.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $day = Days::findOrFail($id);

        $day->delete();

         session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}