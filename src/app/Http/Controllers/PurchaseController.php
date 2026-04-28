<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Purchase;

use Illuminate\View\Component;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $user = auth()->user();
        $item =  Item::findOrFail($item_id);
        $profile = $user->profile;

        if ($item->sold_at) {
            return redirect('/');
        }

        return view('purchase.create', compact('item', 'user', 'profile'));
    }

    public function store(Request $request, $item_id)
    {
        $user = auth()->user();
        $item = Item::findOrFail($item_id);

        if ($item->sold_at) {
            return redirect('/');
        }

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' =>  $item->id,
            'payment_method' => $request->payment_method,
            'post_code' => $user->profile->post_code,
            'address'   => $user->profile->address,
            'building'  => $user->profile->building,

        ]);

        $item->update([
            'sold_at' => now(),
        ]);

        return redirect('/');
    }

    public function editaddress($item_id)
    {
    $user = auth()->user();
    $profile = $user->profile;
    $item = Item::findOrFail($item_id);

    return view('purchase.address',compact('user','profile','item'));
    }

    public function updateaddress(Request $request,$item_id)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $profile->update = ([
        'post_code'=> $request->post_code,
        'address'=> $request->address,
        'building'=> $request->building,
        ]);

        return redirect('/purchase/' . $item_id);
    }
}
