<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // ① 今どのタブか取得
        $tab = $request->query('tab', 'recommend');

        // ② タブごとに処理を分ける
        if ($tab === 'mylist') {
            // いいね未実装なので仮
            $items = collect();

            // 実装後イメージ
            // $items = auth()->user()
            //     ->likes()
            //     ->with('item')
            //     ->get()
            //     ->pluck('item');

        } else {
            // おすすめ（今まで通り）
            $items = Item::all();
        }

        // ③ tabも一緒に渡す
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
