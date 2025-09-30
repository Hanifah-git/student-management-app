<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('roles.index',compact('roles','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('roles.create',compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            // 1024 means 1 MB (because 1024 KB = 1 MB).
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|max:50|unique:roles,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $role = new Role();
        $role->name = $request['name'];
        $role->slug = Str::slug($request['name']);
        $role->status_id = $request['status_id'];
        $role->user_id = $user_id;

        // Remove Old Single Image
        if($request->hasFile('image')){
            $path = $role->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload

        if(file_exists($request['image'])){
            $file = $request['image'];
            // dd($file);
            $fname = $file->getClientOriginalName();
            // dd($fname); //  -8.jpg
            $imagenewname = uniqid($user_id).$role['id'].$fname;
            // dd($imagenewname); // 1689c6d4d2dfd3 -8.jpg
            $file->move(public_path('assets/img/roles'),$imagenewname);

            $filepath = 'assets/img/roles/'.$imagenewname;
            $role->image = $filepath;
        }
        $role->save();

        session()->flash("success","New Role Form Is Created Successfully");
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('roles.edit')->with('role',$role)->with('statuses',$statuses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $role = Role::findOrFail($id);
        $role->name = $request['name'];
        $role->slug = Str::slug($request['name']);
        $role->user_id = $user_id;

        // Remove Old Single Image

        // if there is image file in edit page, then remove the old photo and update the new photo,
        // if not, keep the photo
        if($request->hasFile('image')){
            $path = $role->image;

            if(File::exists($path)){
                File::delete($path);
            }
        }

        // Single Image Upload

        if(file_exists($request['image'])){
            $file = $request['image'];
            // dd($file);
                            //    get file name
            $fname = $file->getClientOriginalName();
            // dd($fname); //  -8.jpg
            $imagenewname = uniqid($user_id).$role['id'].$fname;
            // dd($imagenewname); // 1689c6d4d2dfd3 -8.jpg
            $file->move(public_path('assets/img/roles'),$imagenewname);

            $filepath = 'assets/img/roles/'.$imagenewname;
            $role->image = $filepath;
        }
        

        $role->save();

        session()->flash("success","Updated Successfully");
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // no need to $role = new Role(); cuz you've already given that in store method
        $role = Role::findOrFail($id);

        // Remove Old Single Image
        $path = $role->image;

        if(File::exists($path)){
            File::delete($path);
        }

        $role->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}
