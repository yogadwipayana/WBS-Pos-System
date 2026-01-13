<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Display the view order page with best-selling products.
     */
    public function viewOrderPage()
    {
        // Get top 2 best-selling products based on order_items
        $bestSellingProducts = Product::select('products.*', \DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name', 'products.category_id', 'products.price', 'products.stock', 'products.image', 'products.description', 'products.created_at', 'products.updated_at')
            ->orderByDesc('total_sold')
            ->limit(2)
            ->get();

        return view('view-order', compact('bestSellingProducts'));
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

                // Ensure images directory exists with proper permissions
                $imagesPath = public_path('images');
                if (!file_exists($imagesPath)) {
                    mkdir($imagesPath, 0755, true);
                }

                // Compress and resize image before saving
                $this->compressAndResizeImage($file, $imagesPath, $filename);
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

                // Ensure images directory exists with proper permissions
                $imagesPath = public_path('images');
                if (!file_exists($imagesPath)) {
                    mkdir($imagesPath, 0755, true);
                }

                // Compress and resize image before saving
                $this->compressAndResizeImage($file, $imagesPath, $filename);
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

            // Path file image
            $imagePath = public_path('images/' . $product->image);

            // Hapus file image jika ada
            if ($product->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Hapus data product
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product and image deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Compress and resize image to reduce file size
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath
     * @param string $filename
     * @param int $maxWidth Maximum width in pixels (default: 800)
     * @param int $quality JPEG quality 0-100 (default: 75)
     * @return void
     */
    private function compressAndResizeImage($file, $destinationPath, $filename, $maxWidth = 800, $quality = 75)
    {
        // Get the original image dimensions and type
        $imageInfo = getimagesize($file->getPathname());
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];

        // Calculate new dimensions while maintaining aspect ratio
        if ($originalWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = intval(($originalHeight / $originalWidth) * $maxWidth);
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }

        // Create image resource based on file type
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $sourceImage = imagecreatefromjpeg($file->getPathname());
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($file->getPathname());
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($file->getPathname());
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($file->getPathname());
                break;
            default:
                // If unsupported format, just move the file without compression
                $file->move($destinationPath, $filename);
                return;
        }

        // Create a new true color image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize the image
        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Save the compressed image
        $fullPath = $destinationPath . '/' . $filename;
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($resizedImage, $fullPath, $quality);
                break;
            case 'image/png':
                // PNG quality is 0-9, convert from 0-100 scale
                $pngQuality = intval((100 - $quality) / 11);
                imagepng($resizedImage, $fullPath, $pngQuality);
                break;
            case 'image/gif':
                imagegif($resizedImage, $fullPath);
                break;
            case 'image/webp':
                imagewebp($resizedImage, $fullPath, $quality);
                break;
        }

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }
}
