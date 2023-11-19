<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedController extends Controller
{
    public function createMed(){
        $Cname=request()->input('Commercial_Name');
        $Sname=request()->input('Scientific_Name');
        $manu=request()->input('Manufacturer');
        $rem=request()->input('Remaining');
        $edate=request()->input('Expire_date');
        $cost=request()->input('cost');
        //$categoryname=request()->input('category');
      //  $Category=Category::find($categoryname);
        $attributes=[
            'Commercial_Name'=>$Cname,
            'Scientific_Name'=>$Sname,
            'Manufacturer'=>$manu,
            'Remaining'=>$rem,
            'Expire_date'=>$edate,
            'cost'=>$cost,
           // 'Category'=>$Category
    ];
        $med=Medicine::create($attributes);
        return response()->json(['med'=>$med]);
    }

    public function all(){
        $meds=Medicine::get();
        return response()->json(['meds'=>$meds]);
    }

    public function categoryload(Category $category){
        if(!$category){
            $meds=Medicine::getall();
            return response()->json(['meds'=>$meds]);
        }
        $meds=$category->medicine->load('category');
        return response()->json(['med'=>$meds]);
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
}
