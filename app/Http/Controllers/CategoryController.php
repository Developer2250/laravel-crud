<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductHistory;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = new Category;
                $data->name = $request->input('name');
                $data->description = $request->input('description');
                $data->is_active = 1;

                if ($data->save()) {
                    $data->logHistory(null, 'new category', null, $data, $data->id);

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

    public function destroyAllCategories(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Use Eloquent to delete all categories and their associated products
                Category::with('products')->get()->each(function ($category) {
                    $category->products()->delete();
                    $category->delete();
                });

                return response()->json([
                    'status' => true,
                    'message' => "Successfully deleted all Categories and their associated Products data"
                ], 200);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                $categoryStatus = $request->input('is_active');
                $categoryID = $request->input('category_id');
                if ($categoryStatus) {
                    $category = Category::find($categoryID);
                    $oldValue = $category->is_active;
                    if (!$category) {
                        return response()->json([
                            'message' => 'category not found'
                        ], 404);
                    }

                    $oldValue = $category->toJson();
                    $category->is_active = !$category->is_active;
                    $category->save();

                    ProductHistory::create([
                        'product_id' => null,
                        'field_name' => 'update_status',
                        'old_value' => $oldValue,
                        'new_value' => $category->toJson(),
                        'category_id' => $category->id
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Status updated successfully',
                        'category' => $category
                    ]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function getCategory($id, Request $request)
    {
        if ($request->ajax()) {
            try {
                $category = Category::find($id);
                if (!$category) {
                    return response()->json([
                        'message' => 'category not found'
                    ], 404);
                }

                return response()->json([
                    'status' => true,
                    'category' => $category
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function update($id, Request $request)
    {
        if ($request->ajax()) {
            try {
                $category = Category::find($id);

                if (!$category) {
                    return response()->json([
                        'message' => 'category not found'
                    ], 404);
                }

                $oldValue = $category->toJson();

                // Update the category with the new data
                $category->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    // Add any additional fields you want to update
                ]);

                //update the log table
                ProductHistory::create([
                    'product_id' => null,
                    'field_name' => 'update record',
                    'old_value' => $oldValue,
                    'new_value' => $category->toJson(),
                    'category_id' => $category->id
                ]);

                return response()->json([
                    'status' => true,
                    'category' => $category
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'An error occurred while updating the category.'
                ], 500);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['status' => false, 'message' => 'Category not found.'], 404);
            }
            // Delete associated products
            $category->products()->delete();
            // Delete the category
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Category and associated products deleted successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'An error occurred while deleting the category.'], 500);
        }
    }

    public function getCategoryProduct(Request $request)
    {
        try {
            $categoryId = $request->input('id');
            $category = Category::with(['products' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->find($categoryId);


            return response()->json([
                'status' => true,
                'categories' => $category,
                'productCount' =>  $category->products->count()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => 'An error occurred while fetching the categories.'], 500);
        }
    }

    public function getCategoryActivityLog(Request $request)
    {
        try {
            $categoryId = $request->input('id');
            $category = Category::with(['productsHistory' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])->find($categoryId);

            return response()->json([
                'status' => true,
                'categories' => [
                    'category_name' => $category->name,
                    'products_history'=> $category->productsHistory
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => 'Product history not found.'], 500);
        }
    }

    public function getCategorySingleLogData(Request $request)
    {
        try {
            $categoryId = $request->input('rowId');
            $data= ProductHistory::find($categoryId);
            return response()->json([
               'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => 'Product history not found.'], 500);
        }
    }
}
