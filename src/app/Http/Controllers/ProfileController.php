<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('profiles.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->name = $request->name;
        $profile->post_code = $request->post_code;
        $profile->address = $request->address;
        $profile->building = $request->building;

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }

            $path = $request->file('image')->store('profiles', 'public');

            $profile->image = $path;
        }

        $profile->save();

        return redirect('/');
    }
}
