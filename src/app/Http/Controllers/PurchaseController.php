<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\View\Component;

class PurchaseController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();
        $item =  Item::findOrFail($id);
        $profile =$user->profile;

        return view('purchase.create',compact('item','user','profile'));
    }
}
