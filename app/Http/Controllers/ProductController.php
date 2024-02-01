<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        $categories = Category::where('is_active',1)->get();
        return view('product.index', compact('products','categories'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = new Product;
                $data->name = $request->input('name');
                $data->description = $request->input('description');
                $data->is_active = 1;
                $data->category_id  = $request->input('category_id');
                $data->quantity  = $request->input('quantity');
                $data->price  = $request->input('price');

                if ($data->save()) {
                    $data->logHistory('new product', null, $data, $data->category_id);
                    // $data->logHistory(null,'new category', null,$data, $data->id);
                    return response()->json([
                        'status' => true,
                        'data' => $data
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                    ]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function destroyAllProduct(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Use Eloquent to delete all products
                Product::truncate();
                return response()->json([
                    'status' => true,
                    'message' => "Successfully deleted all product data"
                ], 200);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                $productStatus = $request->input('is_active');
                $productID = $request->input('product_id');
                if ($productStatus) {
                    $product = Product::find($productID);
                    $oldValue = $product->is_active;
                    if (!$product) {
                        return response()->json([
                            'message' => 'Product not found'
                        ], 404);
                    }

                    $product->is_active = !$product->is_active;
                    $product->save();

                    $product->logHistory('is_active', $oldValue, $product->is_active, $product->category_id);

                    return response()->json([
                        'status' => true,
                        'message' => 'Status updated successfully', 
                        'product' => $product
                    ]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function getProductHistory()
    {
        $products = Product::with('histories', 'category')->latest()->get();
        return view('product.history', compact('products'));
    }
}
