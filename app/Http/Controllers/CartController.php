<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = $cartItem->item;
        
        if ($item->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $item->price * $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}