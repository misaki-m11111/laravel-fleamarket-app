<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function create()
    {

        return view('profiles/create');
    }

    public function store(Request $request)
    {
        $profile = Profile::create([

            'user_id' => auth()->id(),
            'name' => $request->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
            'image' => null,

        ]);
        return redirect('/');
    }
}
