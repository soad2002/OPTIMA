<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laptop;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Laptop::orderBy('id', 'desc')->paginate(20);
        return view('admin.products', compact('products'));
    }
}
