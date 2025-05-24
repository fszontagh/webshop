<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the checkout form.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
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
                    'subtotal' => $item->price * $details['quantity']
                ];
                $total += $item->price * $details['quantity'];
            }
        }
        
        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        
        foreach ($cart as $id => $details) {
            $item = Item::find($id);
            if ($item) {
                $total += $item->price * $details['quantity'];
            }
        }
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
        ]);
        
        // Create order items
        foreach ($cart as $id => $details) {
            $item = Item::find($id);
            if ($item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $item->price,
                ]);
            }
        }
        
        // Clear cart
        Session::forget('cart');
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }
}