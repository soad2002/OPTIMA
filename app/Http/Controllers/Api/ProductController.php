<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get all products with filters
     */
    public function index(Request $request)
    {
        $query = Laptop::query();

        // Filter by brands
        if ($request->filled('brands')) {
            $query->whereIn('brand', explode(',', $request->brands));
        }

        // Filter by categories
        if ($request->filled('categories')) {
            $query->whereIn('category', explode(',', $request->categories));
        }

        // Search across name and description
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Price filtering (expects DB price units)
        if ($request->filled('minPrice')) {
            $min = (int)$request->minPrice;
            $query->whereRaw('CAST(price AS INTEGER) >= ?', [$min]);
        }
        if ($request->filled('maxPrice')) {
            $max = (int)$request->maxPrice;
            $query->whereRaw('CAST(price AS INTEGER) <= ?', [$max]);
        }

        // Pagination
        $limit = $request->get('limit', 12);
        $products = $query->paginate($limit);

        // Transform data for frontend
        $mappedProducts = array_map(function ($p) {
            $price = is_numeric($p->price) ? (int)$p->price : (int)preg_replace('/[^0-9]/', '', $p->price ?? 0);
            return [
                'id' => $p->id,
                'name' => $p->name ?: $p->description,
                'price' => $price,
                'image_url' => $p->image_url ? asset($p->image_url) : asset('img/product01.png'),
                'brand' => $p->brand,
                'category' => $p->category ?: 'Laptop',
                'rating' => $p->rating ?? 4,
                'reviews_count' => $p->reviews_count ?? 0,
            ];
        }, $products->items());

        return response()->json([
            'products' => $mappedProducts,
            'total' => $products->total(),
            'pages' => $products->lastPage(),
        ]);
    }

    /**
     * Get a single product by ID
     */
    public function show($id)
    {
        $product = Laptop::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price ?? 0,
            'image_url' => $product->image_url ?? asset('img/product01.png'),
            'brand' => $product->brand,
            'category' => $product->category,
            'rating' => $product->rating ?? 4,
            'reviews_count' => $product->reviews_count ?? 0,
            'color' => $product->color,
            'processor_brand' => $product->processor_brand,
            'processor_model' => $product->processor_model,
            'ram_gb' => $product->ram_gb,
            'storage_gb' => $product->storage_gb,
            'storage_type' => $product->storage_type,
            'screen_size' => $product->screen_size,
            'display_type' => $product->display_type,
            'weight_kg' => $product->weight_kg,
            'os' => $product->os,
            'specs' => [
                'processor' => "{$product->processor_brand} {$product->processor_model}",
                'ram' => "{$product->ram_gb}GB {$product->ram_type}",
                'storage' => "{$product->storage_gb}GB {$product->storage_type}",
                'display' => "{$product->screen_size}\" {$product->display_type}",
                'os' => $product->os,
                'weight' => "{$product->weight_kg}kg",
            ],
        ]);
    }

    /**
     * Get available categories and brands for filtering
     */
    public function filters()
    {
        return response()->json([
            'categories' => [
                [
                    'name' => 'Laptop',
                    'count' => Laptop::count(),
                ],
            ],
            'brands' => Laptop::select('brand')
                ->groupBy('brand')
                ->get()
                ->map(fn ($b) => [
                    'name' => $b->brand,
                    'count' => Laptop::where('brand', $b->brand)->count(),
                ]),
        ]);
    }
}