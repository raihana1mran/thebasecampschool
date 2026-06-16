<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'count' => $products->count(),
            'data' => $products,
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required_without:name|string|max:255',
            'name' => 'required_without:title|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string',
            'files.*' => 'nullable|file',
            'file' => 'nullable|file',
            'preview' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fileURLs = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileURLs[] = $file->store('products/files', 'public');
            }
        } elseif ($request->hasFile('file')) {
            $fileURLs[] = $request->file('file')->store('products/files', 'public');
        }

        $previewURL = '';
        if ($request->hasFile('preview')) {
            $previewURL = $request->file('preview')->store('products/previews', 'public');
        }

        $title = $validated['title'] ?? $validated['name'] ?? 'Untitled Resource';
        $description = $validated['description'] ?? $validated['subject'] ?? 'Uploaded resource';

        $product = Product::create([
            'title' => $title,
            'description' => $description,
            'price' => $validated['price'],
            'category' => $validated['category'] ?? 'other',
            'file_urls' => $fileURLs,
            'preview_url' => $previewURL,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $product,
            ], 201);
        }
        
        return back()->with('success', 'Product created successfully');
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
            return back()->with('error', 'Product not found');
        }

        $product->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Product deleted successfully'
            ]);
        }
        
        return back()->with('success', 'Product deleted successfully');
    }

    public function unlockProduct(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $unlockedProducts = $user->unlocked_products ?? [];

        if (in_array((string)$product->id, $unlockedProducts) || in_array($product->id, $unlockedProducts)) {
            return response()->json(['success' => true, 'message' => 'Product already unlocked', 'product' => $product]);
        }

        if ($user->membership_plan === 'premium') {
            $unlockedProducts[] = $product->id;
            $user->unlocked_products = $unlockedProducts;
            $user->save();
            return response()->json(['success' => true, 'message' => 'Product unlocked successfully (Premium)', 'product' => $product]);
        } else {
            if (count($unlockedProducts) >= 5) {
                return response()->json(['success' => false, 'message' => 'Free plan limit reached (5 materials). Please upgrade to Premium.'], 403);
            }
            $unlockedProducts[] = $product->id;
            $user->unlocked_products = $unlockedProducts;
            $user->save();
            return response()->json(['success' => true, 'message' => 'Product unlocked successfully (Free plan)', 'product' => $product]);
        }
    }
}
