<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sound;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Policies;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function show()
    {
        return view('admin.show');
    }

    public function approve($id)
    {
        $sound = Sound::findOrFail($id);
        $sound->status = 'approved';  // Change status to approved
        $sound->save();

        return redirect()->route('sounds.index')->with('success', 'Sound approved!');
    }

    public function deny($id)
    {
        $sound = Sound::findOrFail($id);
        $sound->status = 'denied';  // Change status to denied
        $sound->save();

        return redirect()->route('sounds.index')->with('error', 'Sound denied.');
    }
}
