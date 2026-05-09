<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'mylist') {
            if (!auth()->check()) {
                $items = collect();
            } else {
                $items = auth()->user()
                    ->likes()
                    ->with('item')
                    ->get()
                    ->pluck('item');
            }
        } else {
            if (auth()->check()) {
                $items = Item::where('user_id', '!=', auth()->id())->get();
            } else {
                $items = Item::all();
            }
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show($item_id)
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
