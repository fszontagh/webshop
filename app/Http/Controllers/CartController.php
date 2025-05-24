<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $id => $details) {
            $item = Item::find($id);
            if ($item) {
                $cartItems[] = [
                    'id' => $id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $details['quantity'],
                    'image' => $item->image,
                    'subtotal' => $item->price * $details['quantity']
                ];
                $total += $item->price * $details['quantity'];
            }
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        $id = $request->id;
        $item = Item::findOrFail($id);
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        
        if ($quantity <= 0) {
            return $this->remove($request);
        }
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request)
    {
        $id = $request->id;
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
    
    /**
     * Get the cart count.
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }
}