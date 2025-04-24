<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'item_id', 'quantity', 'price', 'subtotal'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cartItem) {
            $cartItem->price = $cartItem->item->price;
            $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
        });

        static::updating(function ($cartItem) {
            $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
        });
    }
}
