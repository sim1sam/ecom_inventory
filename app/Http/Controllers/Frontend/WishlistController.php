<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = \App\Models\Wishlist::where('user_id', $user->id)
                                            ->with('product')
                                            ->latest()
                                            ->paginate(12);
        
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a product to the wishlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request, $id = null)
    {
        // Get product_id from URL parameter or request body
        $productId = $id ?? $request->product_id;
        
        $request->merge(['product_id' => $productId]);
        
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);
        
        $user = Auth::user();
        
        // Check if item already exists in wishlist
        $existingItem = \App\Models\Wishlist::where('user_id', $user->id)
                                           ->where('product_id', $productId)
                                           ->first();
        
        if ($existingItem) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is already in your wishlist.'
                ]);
            }
            return redirect()->back()->with('error', 'Product is already in your wishlist.');
        }
        
        // Add to wishlist
        \App\Models\Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully.'
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to wishlist successfully.');
    }

    /**
     * Remove a product from the wishlist.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $user = Auth::user();
        
        $wishlistItem = \App\Models\Wishlist::where('id', $id)
                                           ->where('user_id', $user->id)
                                           ->first();
        
        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Wishlist item not found.'
            ]);
        }
        
        $wishlistItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist successfully.'
        ]);
    }
}