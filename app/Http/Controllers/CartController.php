<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = $user ? $user->cartItems()->with('laptop')->get() : collect();
        if (request()->wantsJson()) {
            return response()->json(['items' => $items->map(function ($i) {
                return [
                    'id' => $i->laptop->id ?? $i->laptop_id,
                    'laptop_id' => $i->laptop_id,
                    'name' => $i->laptop->name ?? null,
                    'price' => $i->laptop->price ?? null,
                    'quantity' => $i->quantity,
                    'image' => $i->laptop->image ?? null,
                ];
            })]);
        }

        return view('cart', ['items' => $items]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $laptopId = $data['productId'] ?? $data['laptop_id'] ?? null;
        $quantity = max(1, (int) ($data['quantity'] ?? 1));

        $request->validate(["productId" => 'required|integer|exists:laptops,id']);

        $user = Auth::user();
        if (! $user) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $item = CartItem::firstOrCreate(
            ['user_id' => $user->id, 'laptop_id' => $laptopId],
            ['quantity' => $quantity]
        );

        if (! $item->wasRecentlyCreated) {
            $item->quantity = $item->quantity + $quantity;
            $item->save();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Added to cart');
    }

    /**
     * Merge client-side cart into server-side cart for authenticated user.
     * Expects JSON: { items: [{ productId: <id>, quantity: <n> }, ...] }
     */
    public function merge(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->validate([
            'items' => 'required|array',
            'items.*.productId' => 'required|integer|exists:laptops,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        foreach ($data['items'] as $it) {
            $laptopId = $it['productId'];
            $quantity = max(1, (int) $it['quantity']);

            $item = CartItem::firstOrCreate([
                'user_id' => $user->id,
                'laptop_id' => $laptopId
            ], ['quantity' => $quantity]);

            if (! $item->wasRecentlyCreated) {
                $item->quantity = $item->quantity + $quantity;
                $item->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function remove(Request $request, $productId = null)
    {
        // support deleting by cart_item id (web) or by product id (api)
        $user = Auth::user();
        if (! $user) {
            if ($request->wantsJson()) return response()->json(['error' => 'Unauthenticated'], 401);
            return redirect()->route('login');
        }

        if ($productId) {
            // remove by laptop_id
            CartItem::where('user_id', $user->id)->where('laptop_id', $productId)->delete();
            if ($request->wantsJson()) return response()->json(['success' => true]);
            return back();
        }

        $request->validate(["id" => 'required|integer|exists:cart_items,id']);
        $item = CartItem::where('id', $request->input('id'))->where('user_id', $user->id)->first();
        if ($item) $item->delete();
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back();
    }
}
