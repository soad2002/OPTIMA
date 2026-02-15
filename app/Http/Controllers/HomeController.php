<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with categories and new products
     */
    public function index()
    {
        // Get categories (mock data for now - update when you have a Category model)
        $categories = [
            (object) [
                'id' => 1,
                'name' => 'Laptops',
                'slug' => 'laptops',
                'image' => 'shop01.png',
            ],
            (object) [
                'id' => 2,
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'image' => 'product07.png',
            ],
            (object) [
                'id' => 3,
                'name' => 'Cameras',
                'slug' => 'cameras',
                'image' => 'shop02.png',
            ],
            (object) [
                'id' => 4,
                'name' => 'Accessories',
                'slug' => 'accessories',
                'image' => 'shop03.png',
            ],
        ];

        // Get new products (latest 8 products)
        $newProducts = Laptop::latest()->take(8)->get();

        return view('home', [
            'categories' => $categories,
            'newProducts' => $newProducts,
        ]);
    }
}
