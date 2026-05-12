<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function create(int $item_id)
    {
        $user = auth()->user();
        $item =  Item::findOrFail($item_id);
        $profile = $user->profile;

        if ($item->user_id === $user->id) {
            return redirect('/');
        }

        if ($item->sold_at) {
            return redirect('/');
        }

        return view('purchase.create', compact('item', 'user', 'profile',));
    }

    public function store(PurchaseRequest $request, int $item_id)
    {
        $user = auth()->user();
        $item = Item::findOrFail($item_id);

        if ($item->user_id === $user->id) {
            return redirect('/');
        }

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

    public function editAddress(int $item_id)
    {
        $user = auth()->user();
        $profile = $user->profile;
        $item = Item::findOrFail($item_id);

        return view('purchase.address', compact('user', 'profile', 'item'));
    }

    public function updateAddress(AddressRequest $request, int $item_id)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $profile->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/purchase/' . $item_id);
    }
}
