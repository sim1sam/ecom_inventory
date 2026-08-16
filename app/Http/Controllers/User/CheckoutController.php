<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BreadcrumbImage;
use Auth;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\City;
use App\Models\Address;
use App\Models\Vendor;
use App\Models\Setting;
use App\Models\Wishlist;
use App\Models\StripePayment;
use App\Models\RazorpayPayment;
use App\Models\Flutterwave;
use App\Models\PaystackAndMollie;
use App\Models\BankPayment;
use App\Models\InstamojoPayment;
use App\Models\PaypalPayment;
use App\Models\ShoppingCart;
use App\Models\SslcommerzPayment;
use App\Models\Coupon;
use App\Models\Shipping;
use Cart;
use Session;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Remove auth middleware to support guest users
    }

    public function checkout(Request $request){
        if (Auth::guard('api')->check()) {
            // Authenticated user - get from database
            $user = Auth::guard('api')->user();
            $cartProducts = ShoppingCart::with('product','variants.variantItem')->where('user_id', $user->id)->select('id','product_id','qty')->get();
            $addresses = Address::with('country','countryState','city')->where(['user_id' => $user->id])->get();
        } else {
            // Guest user - get from session
            $sessionCart = Session::get('guest_cart', []);
            $cartProducts = collect();
            
            foreach ($sessionCart as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $cartItem = (object) [
                        'id' => $item['id'] ?? uniqid(),
                        'product_id' => $item['product_id'],
                        'qty' => $item['quantity'], // Fixed: session cart uses 'quantity' not 'qty'
                        'product' => $product,
                        'variants' => collect($item['variants'] ?? [])
                    ];
                    $cartProducts->push($cartItem);
                }
            }
            $addresses = collect(); // Empty collection for guest users
        }

        if($cartProducts->count() == 0){
            $notification = trans('Your shopping cart is empty');
            return response()->json(['message' => $notification],403);
        }
        $shippings = Shipping::all();

        $couponOffer = '';
        if($request->coupon){
            $coupon = Coupon::where(['code' => $request->coupon, 'status' => 1])->first();
            if($coupon){
                if($coupon->expired_date >= date('Y-m-d')){
                    if($coupon->apply_qty <  $coupon->max_quantity ){
                        $couponOffer = $coupon;
                    }
                }
            }
        }

        $stripePaymentInfo = StripePayment::first();

        $razorpayPaymentInfo = RazorpayPayment::first();

        $flutterwavePaymentInfo = Flutterwave::first();

        $paypalPaymentInfo = PaypalPayment::first();

        $bankPaymentInfo = BankPayment::first();

        $paystackAndMollie = PaystackAndMollie::first();

        $instamojo = InstamojoPayment::first();

        $sslcommerz = SslcommerzPayment::first();

        return response()->json([
            'cartProducts' => $cartProducts,
            'addresses' => $addresses,
            'shippings' => $shippings,
            'couponOffer' => $couponOffer,
            'stripePaymentInfo' => $stripePaymentInfo,
            'razorpayPaymentInfo' => $razorpayPaymentInfo,
            'flutterwavePaymentInfo' => $flutterwavePaymentInfo,
            'paypalPaymentInfo' => $paypalPaymentInfo,
            'bankPaymentInfo' => $bankPaymentInfo,
            'paystackAndMollie' => $paystackAndMollie,
            'instamojo' => $instamojo,
            'sslcommerz' => $sslcommerz,
        ],200);
    }
}

