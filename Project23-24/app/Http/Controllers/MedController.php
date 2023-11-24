<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedController extends Controller
{
    public function createMed(Request $request){
        $cname = $request->cname;//request()->input('Commercial_Name');
        $sname = $request->cname;//request()->input('Scientific_Name');
        $manu = $request->manufacturer;//request()->input('Manufacturer');
        $rem = $request->remain;//request()->input('Remaining');
        $exDate = $request->edate;//request()->input('Expire_date');
        $cost = $request->cost;//request()->input('cost');
        //$categoryname=request()->input('category');
      //  $Category=Category::find($categoryname);

        $attributes=[
            'cname'=>$cname,
            'sname'=>$sname,
            'manufacturer'=>$manu,
            'remain'=>$rem,
            'edate'=>$exDate,
            'cost'=>$cost,
           // 'Category'=>$Category
    ];
        $med=Medicine::create($attributes);
        return response()->json(['med'=>$med]);
    }

    // public function all(){
    //     $meds = Medicine::get();
    //     return response()->json(['meds'=>$meds]);
    // }

    public function categoryload(Category $category){
        $meds=$category->med;
        return response()->json(['meds'=>$meds]);
    }

    public function medshow(Medicine $med){
       return response()->json(['data'=>$med]);
    }

    public function buy(Medicine $med){
        $num=request()->input('num');
        $remain=$med->Remaining;

        if ($num>$remain){
            return response()->json(['message'=>"we don't have this much"]);
        }

        $newremain = $remain-$num;
        $med->Remaining = $newremain;
        $med->save();

        return response()->json([
            'message'=>'updated',
            'data'=>$med
        ]);

    }

    public function add(Medicine $med){
        
        $num=request()->input('num');
        $remain=$med->Remaining;

        if ($num>$remain){
            return response()->json(['message'=>"we don't have this much"]);
        }

        $newremain = $remain+$num;
        $med->Remaining = $newremain;
        $med->save();

        return response()->json([     
            'message'=>'updated',
            'data'=>$med
        ]);

    }

    public function delete($id){
        $med=Medicine::find($id);
        $med->delete();
        //فيك تختصر التابع لسطر واحد
        //$data=Medicine::findorfail($id)->delete();
        return response()->json(['message'=>'product deleted']);
    }
}
