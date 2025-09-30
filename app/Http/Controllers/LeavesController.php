<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Http\Requests\LeaveRequest;
use App\Models\LeaveFile;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::all();
        $users = User::pluck('name','id');
        // dd($users);
        return view('leaves.index',compact('leaves','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()  
    {                                           //    if there is only two value, use pluck , cuz it only get two items your page will load faster 
        $data['posts'] = Post::where('attshow',3)->orderBy('title','asc')->get()->pluck('title','id');
        // dd($data['posts']); // #items: array:3 [▼
//     1 => "CSS Intermediate"
//     3 => "PHP"
//     2 => "WDF Batch 11"
//   ]
        $data['tags'] = User::orderBy('name','asc')->get();
        // when selecting date, today's date will be auto selected
        $data['gettoday'] = Carbon::today()->format('Y-m-d');
        // dd($data['gettoday']); "2025-08-20" //"2025-08-20"  app/Http/Controllers/LeavesController.php:34
        return view('leaves.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeaveRequest $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $leave = new Leave();
        $leave->post_id = json_encode($request['post_id']);
        $leave->startdate = $request['startdate'];
        $leave->enddate = $request['enddate'];
        $leave->tag = json_encode($request['tag']);
        $leave->title = $request['title'];
        $leave->content = $request['content'];
        $leave->user_id = $user_id;
        $leave->save();

        // Remove Old Single Image
        // if($request->hasFile('image')){
        //     $path = $leave->image;

        //     if(File::exists($path)){
        //         File::delete($path);
        //     }
        // }

        // Handle image upload

        if ($request->hasFile('images')) {
            
            foreach($request->file('images') as $file){

                $leavefile = new LeaveFile();
                $leavefile->leave_id = $leave->id;

                $fname = $file->getClientOriginalName();
                $imagenewname = uniqid($user_id).$leave['id'].$fname;
                $file->move(public_path('assets/img/leaves'),$imagenewname);

                $filepath = 'assets/img/leaves/'.$imagenewname;
                $leavefile->image = $filepath;

                $leavefile->save();
            }
        }

        // dd(LeaveFile::where('leave_id',$leave->id)->get());
        


        session()->flash("success","New Leave Form Is Created Successfully");
        return redirect(route('leaves.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leave = Leave::findOrFail($id);
        $leavefiles = LeaveFile::where('leave_id',$id)->get(); // load all images
        $users = User::pluck('name','id');

        return view('leaves.show',["leave"=>$leave,"leavefiles"=>$leavefiles,"users"=>$users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['leave'] = Leave::findOrFail($id);
        $data['leavefiles'] = LeaveFile::where('leave_id',$id)->get(); // load all images
        $data['posts'] = Post::where('attshow',3)->orderBy('title','asc')->pluck('title','id');;
        $data['tags'] = User::orderBy('name','asc')->get();
        
        return view('leaves.edit',$data);
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LeaveRequest $request, string $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $leave = Leave::findOrFail($id);
        $leave->post_id = $request['post_id'];
        $leave->startdate = $request['startdate'];
        $leave->enddate = $request['enddate'];
        $leave->tag = $request['tag'];
        $leave->title = $request['title'];
        $leave->content = $request['content'];

        $leave->save();

        $leavefiles = LeaveFile::where('leave_id',$leave->id)->get();

        if($request->hasFile('images')){

            // Remove Old Multi Image

            foreach($leavefiles as $leavefile){
                $path = $leavefile->image;

                if(File::exists($path)){
                    File::delete($path);
                }     
            }

            // Delete respective image paths from the database
            LeaveFile::where('leave_id',$leave->id)->delete();


            // Multi Image Upload

            foreach($request->file('images') as $image){

                $leavefile = new LeaveFile();
                $leavefile->leave_id = $leave->id;

                $file = $image;
                $fname = $file->getClientOriginalName();
                $imagenewname = uniqid($user_id).$leave['id'].$fname;
                $file->move(public_path('assets/img/leaves'),$imagenewname);

                $filepath = 'assets/img/leaves/'.$imagenewname;
                $leavefile->image = $filepath;

                $leavefile->save();
            }
        }
    
        session()->flash("success","Updated Successfully");
        return redirect(route('leaves.index'));
    }

    public function destroy(string $id)
    {
        $leave = Leave::findOrFail($id);
        $leavefiles = LeaveFile::where('leave_id',$id)->get();

        foreach($leavefiles as $leavefile){

            $path = $leavefile->image;

            if(File::exists($path)){
                File::delete($path);
            }     
        }

        // Delete respective image paths from the database
        LeaveFile::where('leave_id',$leave->id)->delete();
        $leave->delete();

        session()->flash("info","Deleted Successfully");
        return redirect()->back();
    }
}