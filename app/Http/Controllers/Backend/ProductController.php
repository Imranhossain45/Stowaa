<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('categories:id,name')->select('id', 'image', 'title', 'slug', 'status', 'created_at')->orderBy('id', 'desc')->paginate(30);
        $trashProducts = Product::onlyTrashed()->with('categories:id,name')->select('id', 'image', 'title', 'slug', 'status', 'created_at')->orderBy('id', 'desc')->paginate(30);
        return view('backend.product.index', compact('products', 'trashProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $preview_img = 'product.png';
        $galleries = $request->file('gallery');
        $request->validate([
            'title' => 'required|unique:products,title',
            'category_id' => 'required',
            'sku_code' => 'required|integer',
            'short_description' => 'required',
            'price' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'description' => 'nullable',
            'add_info' => 'nullable',
            'image' => 'required|mimes:jpg,jpeg,png,webp|max:512',
            'currency' => 'required',
            'gallery.*' => 'nullable|mimes:jpg,jpeg,png,webp|max:512',
        ]);

        
        
        if ($request->file('image')) {
            $preview_img = Str::uuid() . '.' . $request->image->extension();
            Image::make($request->image)->crop(800,609)->save('storage/product/' . $preview_img);

            $product = Product::create([
                "title" => $request->title,
                "user_id" => auth()->user()->id,
                "sku_code" => $request->sku_code,
                "short_description" => $request->short_description,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "description" => $request->description,
                "add_info" => $request->add_info,
                "image" => $preview_img,
                "currency" => $request->currency,
            ]);

            $product->categories()->attach($request->category_id);
            
            if ($galleries) {
                foreach ($galleries as $galleryImg) {
                    $gallery_img = Str::uuid() . '.' . $galleryImg->extension();
                    Image::make($galleryImg)->crop(800,609)->save('storage/product/' . $gallery_img);
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $gallery_img,
                    ]);
                }
            }


            return back()->with('success', 'Product Insert Successful!');
        } else {
            return back()->with('error', 'Image Not Uploaded!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('backend.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        /* $preview_img = 'product.png'; */
        $img= $request->file('image');
        /* $gallery[]= $request->file('image'); */
        $request->validate([
            'title' => 'required|unique:products,title,'.$product->id,
            'category_id' => 'required',
            'sku_code' => 'required|integer',
            'short_description' => 'required',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'description' => 'nullable',
            'add_info' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:512',
            'currency' => 'required',
            /* 'gallery[]' => 'required', */
        ]);



        if ($img) {
            $preview_img = Str::uuid() . '.' . $request->image->extension();
            Image::make($request->image)->crop(800, 609)->save('storage/product/' . $preview_img);
            
            if(file_exists(public_path('storage/product/'. $product->image))){
                /* Storage::delete('product/'. $product->image); */
                @unlink(public_path('storage/product/' . $product->image));
            }
            
            
            
        }else{
            $preview_img= $product->image;
        }

        
        $product->update([
            "title" => $request->title,
            "sku_code" => $request->sku_code,
            "short_description" => $request->short_description,
            "price" => $request->price,
            "sale_price" => $request->sale_price,
            "description" => $request->description,
            "add_info" => $request->add_info,
            "image" => $preview_img,
            "currency" => $request->currency,
            /* "gallery[]" => $request->gallery[], */
        ]);

        $product->categories()->sync($request->category_id);

        return back()->with('success', 'Product Update Successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {   
        $product->update([
            'status'=> 0,
        ]);
        $product->delete();
        return back()->with('success', 'Product Delete Successful!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {   
        $product= Product::onlyTrashed()->find($id);
        $product->update([
            'status'=> 1,
        ]);
        $product->restore();
        return back()->with('success', 'Product Restore Successful!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function permanentDestroy($id)
    {
        $product = Product::onlyTrashed()->find($id);
      foreach($product->galleries as $gallery) {
            if (file_exists(public_path('storage/product/' . $gallery->image))) {
                /* Storage::delete('product/'. $gallery->image); */
                @unlink(public_path('storage/product/' . $product->image));
            }
      } 
      $product->categories()->detach();
      $product->forceDelete();
      
        return back()->with('success', 'Product Delete Successful!');
    }
}