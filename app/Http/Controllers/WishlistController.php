<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = $user ? $user->wishlistItems()->with('laptop')->get() : collect();
        if (request()->wantsJson()) {
            $mapped = $items->map(function ($i) {
                return [
                    'id' => $i->laptop->id ?? $i->laptop_id,
                    'laptop_id' => $i->laptop_id,
                    'name' => $i->laptop->name ?? null,
                    'image' => $i->laptop->image ?? null,
                ];
            });
            return response()->json($mapped);
        }

        return view('wishlist', ['items' => $items]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $laptopId = $data['productId'] ?? $data['laptop_id'] ?? null;

        $request->validate(["productId" => 'required|integer|exists:laptops,id']);

        $user = Auth::user();
        if (! $user) {
            if ($request->wantsJson()) return response()->json(['error' => 'Unauthenticated'], 401);
            return redirect()->route('login');
        }

        WishlistItem::firstOrCreate([
            'user_id' => $user->id,
            'laptop_id' => $laptopId,
        ]);

        if ($request->wantsJson()) {
            $items = $user->wishlistItems()->with('laptop')->get()->map(function ($i) {
                return [
                    'id' => $i->laptop->id ?? $i->laptop_id,
                    'laptop_id' => $i->laptop_id,
                    'name' => $i->laptop->name ?? null,
                    'image' => $i->laptop->image ?? null,
                ];
            });
            return response()->json($items);
        }

        return back()->with('success', 'Added to wishlist');
    }

    public function remove(Request $request, $productId = null)
    {
        $user = Auth::user();
        if (! $user) {
            if ($request->wantsJson()) return response()->json(['error' => 'Unauthenticated'], 401);
            return redirect()->route('login');
        }

        // allow productId from URL param or JSON body
        $bodyProductId = $request->input('productId') ?? $request->input('laptop_id');
        $effectiveProductId = $productId ?: $bodyProductId;

        if ($effectiveProductId) {
            WishlistItem::where('user_id', $user->id)->where('laptop_id', $effectiveProductId)->delete();
            if ($request->wantsJson()) {
                $items = $user->wishlistItems()->with('laptop')->get()->map(function ($i) {
                    return [
                        'id' => $i->laptop->id ?? $i->laptop_id,
                        'laptop_id' => $i->laptop_id,
                        'name' => $i->laptop->name ?? null,
                        'image' => $i->laptop->image ?? null,
                    ];
                });
                return response()->json($items);
            }
            return back();
        }

        $request->validate(["id" => 'required|integer|exists:wishlist_items,id']);
        $item = WishlistItem::where('id', $request->input('id'))->where('user_id', $user->id)->first();
        if ($item) $item->delete();
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back();
    }
}
