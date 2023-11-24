<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function buy(){
        $medicine=request()->input('medicine');
        $num=request()->input('amount');
        $med=Medicine::where('cname',$medicine);
        $remain=$med->remain;

        if ($num>$remain){
            return response()->json(['message'=>"we don't have this much"]);
        }
        $user=auth()->user()->id;
       
        $order=Order::create([
            'user_id'=>$user,
            'name'=>$medicine,
            'amount'=>$num,
            'status'=>'preparing'
        ]);

        $newremain = $remain-$num;
        $med->remain = $newremain;
        $med->save();

        return response()->json([
            'message'=>'order done',
            'medicine'=>$med,
            'order'=>$order
        ]);
    }
    
    public function orderlist(){
        $orders=Order::all();
        return response()->json(['orders'=>$orders]);
    }



}