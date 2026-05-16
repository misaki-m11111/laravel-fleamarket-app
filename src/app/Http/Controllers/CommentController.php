<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request, int $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->sold_at) {
            return redirect('/');
        }

        $data = $request->validated();

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'content' => $data['content'],
        ]);


        return back();
    }
}
