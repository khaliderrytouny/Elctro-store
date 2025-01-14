<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Catigory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin")->except([
            "index", "show"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home')->with([
            "products" => Product::latest()->simplePaginate(6),
            "categories" => Catigory::has("products")->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.products.create")->with([
            "categories" => Catigory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            "title" => "required|min:3",
            "description" => "required|min:5",
            "image" => "required|image|mimes:png,jpg,jpeg|max:2048",
            "price" => "required|numeric",
            "Catigory_id" => "required|numeric",
        ]);

        //add data
        if ($request->has("image")) {
            $file = $request->image;
            $imageName = "images/products/" . time() . "_" . $file->getClientOriginalName();
            $file->move(public_path("images/products"), $imageName);
            $title = $request->title;

            Product::create([
                "title" => $title,
                "slug" => Str::slug($title),
                "description" => $request->description,
                "price" => $request->price,
                "old_price" => $request->old_price,
                "inStock" => $request->inStock,
                "Catigory_id" => $request->Catigory_id,
                "image" => $imageName,
            ]);
            return redirect()->route("admin.products")
                ->withSuccess("Product added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return view("products.show")->with([
            "product" => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view("admin.products.edit")->with([
            "product" => $product,
            "categories" => Catigory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //validation
        $this->validate($request, [
            "title" => "required|min:3",
            "description" => "required|min:5",
            "image" => "image|mimes:png,jpg,jpeg|max:2048",
            "price" => "required|numeric",
            "Catigory_id" => "required|numeric",
        ]);

        //update data
        if ($request->has("image")) {
            $image_path = public_path("images/products/" . $product->image);
            if (File::exists($image_path)) {
                unlink($image_path);
            }
            $file = $request->image;
            $imageName = "images/products/" . time() . "_" . $file->getClientOriginalName();
            $file->move(public_path("images/products"), $imageName);
            $product->image = $imageName;
        }
        $title = $request->title;
        $product->update([
            "title" => $title,
            "slug" => Str::slug($title),
            "description" => $request->description,
            "price" => $request->price,
            "old_price" => $request->old_price,
            "inStock" => $request->inStock,
            "Catigory_id" => $request->Catigory_id,
            "image" =>  $product->image,
        ]);
        return redirect()->route("admin.products")
            ->withSuccess("Product updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //delete data
        $image_path = public_path("images/products/" . $product->image);
        if (File::exists($image_path)) {
            unlink($image_path);
        }
        $product->delete();
        return redirect()->route("admin.products")
            ->withSuccess("Product deleted");
    }
}
