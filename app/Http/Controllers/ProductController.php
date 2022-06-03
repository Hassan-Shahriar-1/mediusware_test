<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        
            $data_all=Product::all();
            foreach($data_all as $key=>$val){
                foreach($val['price'] as $vkey=>$vval){
                    $name1=ProductVariant::select('variant')->where('id',$vval['product_variant_one'])->first();
                    $name2=ProductVariant::select('variant')->where('id',$vval['product_variant_two'])->first();
                    $name3=ProductVariant::select('variant')->where('id',$vval['product_variant_three'])->first();
                    $name=$name1['variant'].'/'.$name2['variant'].'/'.$name3['variant'];
                    $dd[]=['name'=>$name,'price'=>$vval['price'],'stock'=>$vval['stock']];
                }
                //dd($dd);
                $data[]=['id'=>$val['id'],'title'=>$val['title'],'created_at'=>$val['created_at'],'sku'=>$val['sku'],'description'=>$val['description'],'grp'=>$dd];
                $dd=[];
            }
           // dd($data);

            $data=$this->paginate($data,3);  
            $data->setPath('/product');
           // dd($data);              
            return view('products.index',compact('data'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
      //  dd($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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
        $product=[];$product_variant=[];$product_Variant_price=[];
        /////////product insert inmlimentation////////
        $product['title']=$request->title;
        $product['sku']=$request->sku;
        $product['description']=$request->description;
        $insert_product=Product::create($product);
        //////////product insert end here//////////
        ///////////product varienan implimentation start from here/////////
        if(!empty($request['product_variant'])){
            foreach($request['product_variant'] as $key=>$val){
                if(!empty($val['tags'])){

                    foreach($val['tags'] as $tgkey=>$tgval){
                        $data[]=['variant'=>$tgval,'variant_id'=>$val['option'],'product_id'=>$insert_product->id,'created_at'=>Carbon::now()];
                    }

                }
            }
            $insert_product_variant=ProductVariant::insert($data);
        }
        /////////product varient implimentation end here////////////

        ///////////product price implimentation start from here//////////////

        if($request['product_variant_prices']){
            foreach($request['product_variant_prices'] as $pkey=>$pval){
                $product_var=explode('/',$pval['title']);
               //return $product_var;
                foreach($product_var as $pv_key=>$pv_val){
                    if($pv_val!=null){
                        $variant_price= ProductVariant::select('id','variant_id')->where('variant',$pv_val)->where('product_id',$insert_product->id)->first();
                        /* if($variant_price->variant_id){ */

                        
                            switch($variant_price->variant_id){
                                case '1':
                                    $variant_info[1]=$variant_price->id;
                                    break;
                                case '2':
                                    $variant_info[2]=$variant_price->id;
                                    break;
                                case 6:
                                    $variant_info[6]=$variant_price->id;
                                    break;
                            }
                        /* }else{
                            return 'not working';
                        } */
                        
                    }
                    
                    
                   
                    
                  
                
                }
                if(isset($variant_info[1])){
                    $one=$variant_info[1];
                }else{
                    $one=null;
                }
                if(isset($variant_info[2])){
                    $two=$variant_info[2];
                }else{
                    $two=null;
                }
                if(isset($variant_info[6])){
                    $three=$variant_info[6];
                }else{
                    $three=null;
                }
                $variant_price_data[]=['product_id'=>$insert_product->id,'product_variant_one'=>$one,'product_variant_two'=>$two,'product_variant_three'=>$three,'stock'=>$pval['stock'],'price'=>$pval['price']];
                $variant_info=[];
               // return $variant_info;
                
            }
            ProductVariantPrice::insert($variant_price_data);
        }
        return response()->json($variant_price_data);
        

        //return $insert_product_variant;
        //return $request->all();
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
        $product_variant=ProductVariant::where('product_id',$product->id)->get();
        $product_Variant_price=ProductVariantPrice::where('product_id',$product->id)->get();
        //dd($product_Variant_price);
       
        $variants = Variant::all();
        $finaldata=['variant'=>$variants,'product'=>$product,'product_variant'=>$product_variant,'product_variant_price'=>$product_Variant_price];
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


    public function listofdata(){
        $data=Product::where('id',1)->first();
        dd($data);
        //echo $data;
        return response()->json($data);
    }
}
