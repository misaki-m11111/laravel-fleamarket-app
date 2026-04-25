<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $profile = $user->profile;
        $items = $user->items;
        $tab = $request->query('my','sell');

        if($tab === 'buy'){
            $items = $user->purchase->map(function($purchase){
                return $purchase->item;
            });
        }else{
            $items  = $user->items;
        }

        return  view('mypage.index',compact('user','profile','items','tab',));
    }
}
