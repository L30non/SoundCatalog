<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Sound;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateComplaintRequest;
use App\Http\Requests\StoreComplaintRequest;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $complaints = Complaint::where('user_id', Auth::id())->get();
        return view("sounds.complaint", compact("complaints"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $sound_id = $request->query('sound_id');

        if(!$sound_id) {
            return redirect()->route('sounds.index')->with('error','Please select a manual to file a complaint.');
        }

        $complaint_type = Complaint::$complaint_type;

        $sound = Sound::findOrFail($sound_id);
        return view("sounds.complaint", compact("sound", "complaint_type"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        //
        // dd($request->all());
        $complaint = new Complaint();
        $complaint->sound_id = $request->sound_id;
        $complaint->user_id = Auth::id();
        $complaint->complaint_type = $request->complaint_type;
        $complaint->description = $request->description;
        $complaint->save();

        return redirect()->route("sounds.complaint")->with('success', 'Complaint uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
