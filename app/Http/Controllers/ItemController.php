<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(10); // Menggunakan paginate() dengan 10 item per halaman
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil dihapus.');
    }
}