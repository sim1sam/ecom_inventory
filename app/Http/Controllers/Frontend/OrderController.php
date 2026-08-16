<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = collect();
        
        try {
            if (class_exists('App\Models\Order')) {
                $orderModel = app('App\Models\Order');
                $query = $orderModel->with(['orderProducts.product', 'orderAddress'])
                                   ->where('user_id', $user->id);
                
                // Filter by status if provided
                if ($request->has('status') && $request->status) {
                    $query->where('order_status', $request->status);
                }
                
                $orders = $query->latest()->paginate(10);
            }
        } catch (\Exception $e) {
            \Log::info('Order model not found or has different structure: ' . $e->getMessage());
        }
        
        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $order = null;
        
        try {
            if (class_exists('App\Models\Order')) {
                $orderModel = app('App\Models\Order');
                $order = $orderModel->with(['orderProducts.product', 'orderAddress'])
                                   ->where('user_id', $user->id)
                                   ->where('id', $id)
                                   ->first();
                
                if (!$order) {
                    abort(404, 'Order not found.');
                }
            } else {
                abort(404, 'Order functionality not available.');
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching order: ' . $e->getMessage());
            abort(404, 'Order not found.');
        }
        
        $setting = \App\Models\Setting::first();
        
        // Get payment gateway settings for the payment options
        $stripe_setting = \App\Models\StripePayment::first();
        $paypal_setting = \App\Models\PaypalPayment::first();
        $razorpay_setting = \App\Models\RazorpayPayment::first();
        $flutterwave_setting = \App\Models\Flutterwave::first();
        $mollie_setting = \App\Models\PaystackAndMollie::first();
        $instamojo_setting = \App\Models\InstamojoPayment::first();
        $paystack_setting = \App\Models\PaystackAndMollie::first();
        $sslcommerz_setting = \App\Models\SslcommerzPayment::first();
        $bank_payment_setting = \App\Models\BankPayment::first();
        
        return view('frontend.orders.show', compact(
            'order', 
            'setting',
            'stripe_setting',
            'paypal_setting', 
            'razorpay_setting',
            'flutterwave_setting',
            'mollie_setting',
            'instamojo_setting',
            'paystack_setting',
            'sslcommerz_setting',
            'bank_payment_setting'
        ));
    }
}