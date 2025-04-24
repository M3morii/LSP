<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        $cartItems = $cart->cartItems()->with('item')->get();
        
        return view('cart.index', compact('cart', 'cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($request->item_id);
        
        if ($item->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        
        $existingCartItem = $cart->cartItems()->where('item_id', $request->item_id)->first();
        
        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $request->quantity;
            
            if ($item->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }
            
            $existingCartItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $item->price * $newQuantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, CartItem $cartItem)
    {
        $action = $request->action ?? null;
        $quantity = $cartItem->quantity;
        
        if ($action === 'increase') {
            $quantity += 1;
        } elseif ($action === 'decrease') {
            $quantity = max(1, $quantity - 1);
        } else {
            $quantity = max(1, $request->quantity);
        }

        $item = $cartItem->item;
        
        if ($item->stock < $quantity) {
            return redirect()->back();
        }

        $cartItem->update([
            'quantity' => $quantity,
            'subtotal' => $item->price * $quantity,
        ]);

        return redirect()->route('cart.index');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    public function checkout(Request $request)
    {
        // Get the user's cart and cart items
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }
        
        // Generate a unique transaction code
        $transactionCode = 'TRX-' . strtoupper(Str::random(10));
        
        // Create a new transaction
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => $transactionCode,
            'total_amount' => $cart->cartItems->sum(function($item) { 
                return $item->item->price * $item->quantity; 
            }),
            'status' => 'completed',
            'payment_method' => 'cash',
        ]);
        
        // Add transaction items
        foreach ($cart->cartItems as $cartItem) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
                'subtotal' => $cartItem->item->price * $cartItem->quantity,
            ]);
            
            // Update stock if needed
            $item = $cartItem->item;
            $item->stock -= $cartItem->quantity;
            $item->save();
        }
        
        // Clear the cart
        $cart->cartItems()->delete();
        
        return redirect()->route('transactions.index')->with('success', 'Pembayaran berhasil');
    }
}