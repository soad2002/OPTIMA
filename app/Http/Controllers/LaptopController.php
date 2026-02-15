<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaptopController extends Controller
{
    /**
     * Get all laptops with filters and pagination
     */
    public function index(Request $request)
    {
        $query = DB::table('laptops');

        // Text search (name and description)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('categories')) {
            $categories = explode(',', $request->categories);
            $query->whereIn('category', $categories);
        }

        // Brand filter
        if ($request->filled('brands')) {
            $brands = explode(',', $request->brands);
            $query->whereIn('brand', $brands);
        }

        // Price range filter
        if ($request->filled('minPrice')) {
            $query->where('price', '>=', $request->minPrice);
        }
        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest();
                break;
        }

        // Pagination
        $limit = $request->get('limit', 12);
        $laptops = $query->paginate($limit);

        return response()->json([
            'products' => $laptops->items(),
            'total' => $laptops->total(),
            'pages' => $laptops->lastPage(),
        ]);
    }

    /**
     * Get available categories and brands for filtering
     */
    public function getFilters()
    {
        $categories = DB::table('laptops')
            ->select('category as name', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        $brands = DB::table('laptops')
            ->select('brand as name', DB::raw('count(*) as count'))
            ->groupBy('brand')
            ->get();

        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}