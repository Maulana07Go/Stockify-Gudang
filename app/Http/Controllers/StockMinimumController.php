<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockMinimumController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'name', 'minimum_stock')->get();
        return view('admin.stock.minimum.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.stock.minimum.edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'reorder_point' => 'required|numeric|min:0',
            'average_usage' => 'required|numeric|min:0',
            'average_lead_time' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);

        $minimumStock = $request->reorder_point - ($request->average_usage * $request->average_lead_time);

        $product->update([
            'reorder_point' => $request->reorder_point,
            'average_usage' => $request->average_usage,
            'average_lead_time' => $request->average_lead_time,
            'minimum_stock' => max(0, $minimumStock), // Pastikan nilai tidak negatif
        ]);

        return redirect()->route('admin.stock.minimum.index')->with('success', 'Stok minimum berhasil diperbarui.');
    }
}
