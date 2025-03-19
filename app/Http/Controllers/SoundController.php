<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sound;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Policies;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,)
    {

        $title =$request->input('title');
        $filter = $request->input('filter','');

        $sounds = Sound::query()
            ->when($title, function ($query, $title) {
                return $query->title($title);
            })
            ->when($filter, function ($query, $filter) {
                return $query->filterByCategory($filter);
            })
            ->where('status','approved')
            ->with('category')
            ->paginate(10);
        
        
        return view('sounds.index',compact('sounds','title','filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create',Sound::class);
        $categories = Category::all();
        return view('sounds.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create',Sound::class);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $filePath = $request->file('file_path')->store('sound','public');
        $imagePath = $request->file('image_path')->store('images','public');

        $sound = new Sound($data);
        $sound->user_id = Auth::user()->id;
        $sound->file_path = $filePath;
        $sound->image_path = $imagePath;
        $sound->category_id = $request->category_id;
        $sound->save();

        return redirect()->route('sounds.index')->with('success','Sound Added Successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sound = Sound::findOrFail($id);

        if($sound->status !== 'approved' && !Gate::allows('manage-sound',$sound))
        {
            abort(403);
        }

        return view('sounds.show',compact('sound'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sound = Sound::findOrFail($id);

        $this->authorize('update',$sound);

        $categories = Category::all();

        return view('sounds.edit',compact('sound','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav',
            'category_id' => 'required|exists:categories,id',
        ]);

        $sound = Sound::findOrFail($id);
        
        $this->authorize('update',$sound);
        
        if($request->hasFile('file_path')){
            $filePath = $request->file('file_path')->store('sounds','public');
            $sound->file_path = $filePath;
        }
        
        $sound->update($data);

        return redirect()->route('sounds.index')->with('success','Sound Edited Successully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sound = Sound::findOrFail($id);

        $this->authorize('delete',$sound);

        Storage::disk('public')->delete([$sound->file_path,$sound->image_path]);

        $sound->delete();

        return redirect()->route('sounds.index')->with('success','Sound Deleted Successully!!');
    }

    public function download($id)
    {
        $sound = Sound::findOrFail($id);

        if($sound->status !== 'approved' && !Gate::allows('manage-sound',$sound))
        {
            abort(403);
        }
        
        if (Storage::disk('public')->exists($sound->file_path)) {
            return response()->download(storage_path('app/public/' . $sound->file_path));
        }

        return redirect()->route('sounds.index')->with('error', 'File not found.');
    }
}
