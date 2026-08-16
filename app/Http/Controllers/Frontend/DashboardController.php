<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user statistics
        $totalOrders = 0;
        $completedOrders = 0;
        $wishlistCount = 0;
        $recentOrders = collect();
        
        // Try to get orders if Order model exists
        try {
            if (class_exists('App\Models\Order')) {
                $orderModel = app('App\Models\Order');
                $totalOrders = $orderModel->where('user_id', $user->id)->count();
                $completedOrders = $orderModel->where('user_id', $user->id)
                                             ->where('order_status', 3)
                                             ->count();
                $recentOrders = $orderModel->where('user_id', $user->id)
                                          ->latest()
                                          ->take(5)
                                          ->get();
            }
        } catch (\Exception $e) {
            // Handle case where Order model doesn't exist or has different structure
            \Log::info('Order model not found or has different structure: ' . $e->getMessage());
        }
        
        // Try to get wishlist count if Wishlist model exists
        try {
            if (class_exists('App\Models\Wishlist')) {
                $wishlistModel = app('App\Models\Wishlist');
                $wishlistCount = $wishlistModel->where('user_id', $user->id)->count();
            }
        } catch (\Exception $e) {
            // Handle case where Wishlist model doesn't exist
            \Log::info('Wishlist model not found: ' . $e->getMessage());
        }
        
        return view('frontend.dashboard.index', compact(
            'totalOrders',
            'completedOrders', 
            'wishlistCount',
            'recentOrders'
        ));
    }
}