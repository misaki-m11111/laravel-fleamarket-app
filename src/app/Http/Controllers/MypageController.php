<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $profile = $user->profile;
        $products = $user->products;
        $tab = $request->query('my','sell');

        if($tab === 'buy'){
            $products = $user->purchase->map(function($purchase){
                return $purchase->product;
            });
        }else{
            $products  = $user->products;
        }

        return  view('mypage.index',compact('user','profile','products','tab',));
    }
}
