<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->keyword;

        if ($tab === 'mylist') {
            if (!auth()->check()) {
                $items = collect();
            } else {
                /** @var \App\Models\User $user */
                $user = auth()->user();

                $items = $user->likes()
                    ->with('item')
                    ->get()
                    ->pluck('item');

                if (!empty($keyword)) {
                    $items = $items->filter(function ($item) use ($keyword) {
                        return str_contains($item->name, $keyword);
                    });
                }
            }
        } else {
            $query = Item::query();

            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }

            if (!empty($keyword)) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }

            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show(int $item_id)
    {
        $item = Item::with('categories')->findOrFail($item_id);

        return  view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Item::CONDITIONS;

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $items = Item::create([
            'user_id' => auth()->user()->id,
            'image' => $path,
            'name' => $request->name,
            'condition' => $request->condition,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $items->categories()->attach($request->categories);

        return redirect('/');
    }
}
