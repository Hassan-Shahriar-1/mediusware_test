<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
  /////////////////product implimentation///////////////////////
       $product=[];
       $product['title']=$request->title;
       $product['sku']=$request->sku;
       $product['description']=$request->description;
       $product_insert=Product::create($product);
/////////////// product part end here/////////////////////


//////////////product variant start from here/////////////////
       if(!empty($request['product_variant'])){
           foreach($request['product_variant'] as $key=>$val){
                foreach($val['tags'] as $k=>$v){
                    $product_varients[]=['variant'=>$v,'variant_id'=>$val['option'],'product_id'=>$product_insert->id];

                }
                
           }
           $varient_insert=ProductVariant::insert($product_varients);
       }

//////////////product variant end here/////////////////

/////////////////variant price implimnet////////////////////
       if(!empty($request['product_variant_prices'])){
           foreach($request['product_variant_prices'] as $vrkey=>$vrval){
              
               $data=array(explode('/',$vrval['title']));
               
                foreach($data as $k=>$v){
                    if($v!='' or $v!=null){
                        $varint[]=ProductVariant::select('id')->where('variant',$v)->where('product_id',$product_insert->id)->first();
                    }

                }
                $product_varient_price[]=['product_id'=>$product_insert->id,'product_variant_one'=>$varint[0],'product_variant_two'=>$varint[1],'product_variant_one'=>$varint[2],'stock'=>$vrval['stock'],'price'=>$vrval['price']];
           }
       }

/////////////////variant price implimnet end here////////////////////
       

       
      return $request->all();

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    public function all(){/////////getting all product by grouping for product list page
        $list=Product::where('id',1)->first();
       // dd($list);
    }
}
