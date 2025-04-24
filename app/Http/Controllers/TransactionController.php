<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('transactions.index', compact('transactions'));
    }

    public function checkout()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        return view('transactions.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();
        
        try {
            // Buat transaksi baru
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total_amount' => $cart->total,
                'transaction_code' => 'TRX-' . Str::random(10),
                'status' => 'completed',
            ]);
            
            // Tambahkan item transaksi dan update stok
            foreach ($cart->cartItems as $cartItem) {
                $item = $cartItem->item;
                
                // Periksa stok sekali lagi
                if ($item->stock < $cartItem->quantity) {
                    throw new \Exception('Stok ' . $item->name . ' tidak mencukupi.');
                }
                
                // Buat item transaksi
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->subtotal,
                ]);
                
                // Update stok item
                $item->update([
                    'stock' => $item->stock - $cartItem->quantity
                ]);
            }
            
            // Kosongkan keranjang
            $cart->cartItems()->delete();
            
            DB::commit();
            
            return redirect()->route('transactions.receipt', $transaction)
                ->with('success', 'Transaksi berhasil.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function receipt(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('transactions.receipt', compact('transaction'));
    }
}