<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Color;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'title', 'slug', 'short_description', 'price', 'sale_price', 'image','currency')->orderBy('id','desc')->paginate(30);
        return view('frontend.shop.index', compact('products'));
    }
    public function shopDetails($slug)
    {
        $product = Product::with('galleries','inventories.size','inventories.color')->where('slug',$slug)->firstOrFail();
        $size = Inventory::where('product_id', $product->id)->get();
        $sizeOf= $size->unique(function($item){
            return $item['size_id'];
        });

        $user_order_check = [];
        foreach
        (auth()->user()->inventories as $order_inventory){
            $user_order_check = array_merge($user_order_check, $order_inventory->inventory->pluck('product_id')->toArray());
        }
        $user_order_check= array_unique($user_order_check);

        return view('frontend.shop.details', compact('product', 'sizeOf', 'user_order_check'));
    }
    public function shopColor(Request $request){
        $inventories = Inventory::where('product_id', $request->product_id)->where('size_id', $request->size_id)->get();
        $ex_color = $inventories->pluck('color_id')->toArray();
        $colors = Color::whereIn('id', $ex_color)->get();

        $options = ["<option>Choose A Option</option>n>"];
        foreach ($colors as $color) {
            $options[] = "<option value='" . $color->id . "'>" . $color->name . "</option>";
        }

        return response()->json($options);
    }
    public function shopSizeColor(Request $request){
        $inventory = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first();   
        
        $product= $inventory->product;
        if($product->sale_price !=null){
            $original_price=$product->sale_price+ $inventory->additional_price;
        }else{
            $original_price = $product->price + $inventory->additional_price;
        }

        $data=[
            "id"=> $inventory->id,
            "quantity"=>$inventory->quantity,
            "original_price"=> $original_price,
        ];
        return response()->json($data);
    }
}