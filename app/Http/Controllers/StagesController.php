<?php

namespace App\Http\Controllers;

use APP\Models\Stages;
use APP\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class StagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = Stages::all();
        $statuses = Status::whereIn('id',3,4)->get();
        return view('stages.index',compact('stages','statuses'));
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
            'name' => 'required|max:50|unique:types,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $stage = new Stages();
        $stage -> name = $request['name'];
        $stage -> slug = $request['slug'];
        $stage -> status_id = $request['status_id'];
        $stage -> user_id = $user_id;
        $stage -> save();

        return redirect(route('stages.index'));
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

        $stage = Stages::findOrFail($id);
        $stage -> name = $request['name'];
        $stage -> slug = $request['slug'];
        $stage -> status_id = $request['status_id'];

        $stage -> save();

        return redirect(route('stages.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stage = Stages::findOrFail($id);

        $stage -> delete();

        return redirect(route('stages.index'));
    }
}
