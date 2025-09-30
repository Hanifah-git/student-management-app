<?php

namespace App\Http\Controllers;

use App\Models\Religions;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ReligionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $religions = Religions::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('religions.index', compact('religions','statuses'));
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
            'name' => 'required|max:50|unique:religions,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $religion = new Religions();
        $religion->name = $request['name'];
        $religion->slug = Str::slug($request['slug']);
        $religion->status_id = $request['status_id'];
        $religion->user_id = $user_id;
        $religion->save();

        session()->flash("success","New Religion Form Is Created Successfully");
        return redirect(route('religions.index'));
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

        $religion = Religions::findOrFail($id);
        $religion->name = $request['name'];
        $religion->slug = Str::slug($request['slug']);
        $religion->user_id = $user_id;

        $religion->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('religions.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $religion = Religions::findOrFail($id);

        $religion->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}
