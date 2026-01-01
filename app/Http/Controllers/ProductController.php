<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the order page with categories.
     */
    public function orderPage()
    {
        $categories = Category::with('products')->get();
        return view('order', compact('categories'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'required|image|max:2048', // Max 2MB
                'description' => 'nullable|string',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Create slug from product name: lowercase and replace spaces with hyphens
                $slug = strtolower(str_replace(' ', '-', $validated['name']));
                $extension = $file->getClientOriginalExtension();
                $filename = $slug . '.' . $extension;
                $file->move(public_path('images'), $filename);
                $validated['image'] = $filename;
            }

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $rules = [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable', // allow string if no new file
                'description' => 'nullable|string',
            ];

            // If a file is uploaded, apply image validation rules
            if ($request->hasFile('image')) {
                $rules['image'] = 'image|max:2048';
            }

            $validated = $request->validate($rules);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $validated['image'] = $filename;

                // Optional: Delete old image if exists
                if ($product->image && file_exists(public_path('images/' . $product->image))) {
                    // unlink(public_path('images/' . $product->image));
                }
            } else {
                // If no new image is uploaded, we might receive the old filename as string or null
                // We typically remove 'image' from validated if it's not present or handled differently
                // But if the frontend sends the old filename as specific field, we handle it.
                // Here, standard file input doesn't send anything if empty.
                // If we want to keep existing image, we just don't update the image field if no file is sent.
                unset($validated['image']);
            }

            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
