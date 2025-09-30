<?php

namespace App\Http\Controllers;

use App\Models\Warehouses;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouses::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('warehouses.index', compact('warehouses','statuses'));
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
            'name' => 'required|max:50|unique:warehouses,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $warehouse = new Warehouses();
        $warehouse->name = $request['name'];
        $warehouse->slug = Str::slug($request['slug']);
        $warehouse->status_id = $request['status_id'];
        $warehouse->user_id = $user_id;
        $warehouse->save();

        session()->flash("success","New Leave Form Is Created Successfully");
        return redirect(route('warehouses.index'));
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

        $warehouse = Warehouses::findOrFail($id);
        $warehouse->name = $request['name'];
        $warehouse->slug = Str::slug($request['slug']);
        $warehouse->user_id = $user_id;

        $warehouse->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('warehouses.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = Warehouses::findOrFail($id);

        $warehouse->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();

    }
}
