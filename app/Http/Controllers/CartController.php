<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function addProductToCart(Request $request, Product $product)
    {
        Cart::add([
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => $request->qty,
            'attributes' => [],
            'associatedModel' => $product,
        ]);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier!');
    }
    
    public function index()
    {
        $items = Cart::getContent();
        return view('cart.index', compact('items'));
    }
    
    public function updateProductInCart(Request $request, Product $product)
    {
        Cart::update($product->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty,
            ],
        ]);

        return redirect()->route('cart.index');
    }
    
    public function removeProductFromCart(Product $product)
    {
        Cart::remove($product->id);
        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier!');
    }
}
