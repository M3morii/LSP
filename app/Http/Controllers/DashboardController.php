<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryCount = Category::count();
        $itemCount = Item::count();
        $transactionCount = Transaction::count();
        $totalSales = Transaction::where('status', 'completed')->sum('total_amount');
        
        $latestTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $lowStockItems = Item::where('stock', '<', 10)->get();
        
        return view('dashboard', compact(
            'categoryCount', 
            'itemCount', 
            'transactionCount', 
            'totalSales', 
            'latestTransactions', 
            'lowStockItems'
        ));
    }
}