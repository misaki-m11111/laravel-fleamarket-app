<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    public function store(int $item_id)
    {
        Like::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
        ]);

        return back();
    }

    public function destroy(int $item_id)
    {
        Like::where('user_id', auth()->id())
            ->where('item_id', $item_id)
            ->delete();

        return back();
    }
}
