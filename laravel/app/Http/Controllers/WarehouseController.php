<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private static $products = [
        ['id' => 1, 'title' => 'Laptop ASUS', 'sku' => 'WH-LAP-01', 'quantity' => 15, 'price' => 1200.00],
        ['id' => 2, 'title' => 'Wireless Mouse', 'sku' => 'WH-MOU-05', 'quantity' => 120, 'price' => 25.50],
        ['id' => 3, 'title' => 'Mechanical Keyboard', 'sku' => 'WH-KEY-12', 'quantity' => 45, 'price' => 85.00]
    ];

    public function index()
    {
        return response()->json(self::$products, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'sku' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $newProduct = [
            'id' => count(self::$products) + 1,
            'title' => $validated['title'],
            'sku' => $validated['sku'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price']
        ];

        return response()->json([
            'message' => 'Product successfully added to Warehouse',
            'product' => $newProduct
        ], 201);
    }

    public function show($id)
    {
        foreach (self::$products as $product) {
            if ($product['id'] == $id) {
                return response()->json($product, 200);
            }
        }

        return response()->json(['error' => 'Product not found in Laravel Warehouse'], 404);
    }

    public function update(Request $request, $id)
    {
        $productFound = null;
        foreach (self::$products as $product) {
            if ($product['id'] == $id) {
                $productFound = $product;
                break;
            }
        }

        if (!$productFound) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $updatedData = array_merge($productFound, $request->only(['title', 'sku', 'quantity', 'price']));

        return response()->json([
            'message' => "Product ID $id updated successfully",
            'updated_product' => $updatedData
        ], 200);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => "Product ID $id has been successfully removed from Warehouse"
        ], 200);
    }
}
