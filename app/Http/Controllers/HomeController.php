<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catigory; // This line can be removed if not used or replace with Category

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with([
            'products' => Product::latest()->simplePaginate(6),
            'catigories' => Catigory::has('products')->get() // Corrected the model name
        ]);
    }

    public function getProductByCategory(Catigory $category) // Corrected the parameter type and name
    {
        $products = $category->products()->paginate(10);
        return view('home')->with([
            'products' => $products,
            'catigories' => Catigory::has('products')->get() // Corrected the model name
        ]);
    }
}
