<?php

namespace App\Http\Controllers;

use App\Models\PaymentTypes;
use App\Models\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PaymentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymenttypes = PaymentTypes::all();
        $statuses = Status::whereIn('id',[3,4])->get();
        return view('paymenttypes.index', compact('paymenttypes','statuses'));
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
            'name' => 'required|max:50|unique:payment_types,name',
            'status_id' => 'required|in:3,4'
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $paymenttype = new PaymentTypes();
        $paymenttype->name = $request['name'];
        $paymenttype->slug = Str::slug($request['slug']);
        $paymenttype->status_id = $request['status_id'];
        $paymenttype->user_id = $user_id;
        $paymenttype->save();

        return redirect(route('paymenttypes.index'));
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

        $paymenttype = PaymentTypes::findOrFail($id);
        $paymenttype->name = $request['name'];
        $paymenttype->slug = Str::slug($request['slug']);
        $paymenttype->user_id = $user_id;

        $paymenttype->save();

        return redirect(route('paymenttypes.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymenttype = PaymentTypes::findOrFail($id);

        $paymenttype->delete();

        return redirect()->back();
    }
}
