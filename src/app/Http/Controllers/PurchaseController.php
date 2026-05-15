<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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

        if (app()->environment('testing')) {
            return redirect('/');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = $request->payment_method == 1
            ? ['konbini']
            : ['card'];

        $checkoutSession = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/'),
            'cancel_url' => url('/purchase/' . $item->id),
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(int $item_id)
    {
        return redirect('/');
    }

    public function cancel(int $item_id)
    {
        return redirect('/purchase/' . $item_id);
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
