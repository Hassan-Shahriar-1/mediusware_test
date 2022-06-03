<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariantPrice;

use Illuminate\Pagination\Paginator ;

class my_product extends Controller
{
   public  function filter_product(Request $request){
     /*   if($request->all()==null){
           return;

       } */
       //$all_product=Product::()->paginate(3);
      // dd($all_product);
    if($request['title']!=null && $request['variant']==null && ($request['price_from']==null&&$request['price_to']==null)&&$request['date']==null){
        $data=Product::where('title','like','%'.$request['title'].'%')->paginate(3);
        return view('products.index',compact('data'));
       }
    else if($request['title']==null&&$request['variant']==null&&($request['price_from']==null&&$request['price_to']==null)&&$request['date']!=null){
        $data=Product::whereDate('created_at',$request['date'])->paginate(3);
        return view('products.index',compact('data'));
    }
    else if($request['title']==null&&$request['variant']==null&&($request['price_from']!=null||$request['price_to']!=null)&&$request['date']==null){
        if($request['price_from']==null){
            $request['price_from']=0;
        }
       // dd($request['price_from'],$request['price_to']);
        $data1=ProductVariantPrice::whereBetween('price',[$request['price_from'],$request['price_to']])->get();
       // dd($data[0]->product);
       foreach($data1 as $key=>$val){
           $data[]=$val->product;
       }
       //dd($data);
       $data=new Paginator($data,count($data),3);
       dd($data);
        return view('products.index',compact('data'));
    }
    else if($request['title']==null&&$request['variant']==null&&($request['price_from']==null&&$request['price_to']!=null)&&$request['date']==null){
        dd('price_final');
    }
    else if($request['title']==null&&$request['variant']!=null&&($request['price_from']==null&&$request['price_to']==null)&&$request['date']==null){
        dd('vr');
    }else{
        dd('not working');
    }

   }
   
}
