<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('categories.index', compact('categories','statuses'));
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
            'name' => 'required|max:50|unique:categories,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $category = new Categories();
        $category->name = $request['name'];
        $category->slug = Str::slug($request['slug']);
        $category->status_id = $request['status_id'];
        $category->user_id = $user_id;
        $category->save();

        session()->flash("success","New Category Form Is Created Successfully");
        return redirect(route('categories.index'));
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

        $category = Categories::findOrFail($id);
        $category->name = $request['name'];
        $category->slug = Str::slug($request['slug']);
        $category->user_id = $user_id;

        $category->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::findOrFail($id);

        $category->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}

